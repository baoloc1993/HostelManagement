/**
 * Created by Luis Ngo on 22/9/2017.
 */
 
var files = [];
function handleImg(room){
    $("#img_id").attr("src",room.img_id);
    $("#img_person").attr("src",room.img_person);
    $("#img_bike").attr("src",room.img_bike);
    var check = false;
    if (room.img_id === ""){
        $("#img_id_container .input-field").show();
        check = true;
    }else{
        $("#img_id_container").append("<a class=\"waves-effect waves-light btn modal-trigger remove_image\" id =\"remove_id\">Xóa</a>");
    }
    if (room.img_person === ""){
        $("#img_person_container .input-field").show();
        check = true;
    }else{
        $("#img_person_container").append("<a class=\"waves-effect waves-light btn modal-trigger remove_image\" id =\"remove_person\">Xóa</a>");
    }
    if (room.img_bike === ""){
        $("#img_bike_container .input-field").show();
        check = true;
    }else{
        $("#img_bike_container").append("<a class=\"waves-effect waves-light btn modal-trigger remove_image\" id =\"remove_bike\">Xóa</a>");
    }
    
    if (check){
        $("#img-submit").show();
    }
    $("#img-submit").click(function(){
        var data = new FormData();
        data.append("id",room.id);
        if (room.img_id === "") data.append("img_id", files[0]);
        if (room.img_person === "") data.append("img_person",files[1]);
        if (room.img_bike === "") data.append("img_bike",files[2]);
        
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "api/room_manager.php");
        xhr.send(data);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                //var response = JSON.parse(xhr.responseText);
                if (xhr.status === 200 ) {
                    alert("Cập nhật thành công");
                    window.location.href= "room.php?id=" + room.room_id;
                } else {
                    alert("Cập nhật không thành công");
                }
            }
        }
    });
    
    $(".remove_image").click(function(e){
        var data = new FormData();
        data.append("id",room.id);
        var img = e.target.id.replace('remove','img');
        data.append("type",img);
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "api/room_manager.php");
        xhr.send(data);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                //var response = JSON.parse(xhr.responseText);
                if (xhr.status === 200 ) {
                    alert("Cập nhật thành công");
                    window.location.href= "room.php?id=" + room.room_id;
                } else {
                    alert("Cập nhật không thành công");
                }
            }
        }
    });
}

function fileUpload(event){
    var name = event.target.name;
    if (name == "img_id"){
        files[0] = event.target.files[0];
    }else if (name == "img_person"){
        files[1] = event.target.files[0];
    }else if (name == "img_bike"){
        files[2] = event.target.files[0];
    }
}
$('input[type=file]').on('change', fileUpload);

$( "#add_service" ).click(function() {

    $("#modal1").openModal();

});
$( "#accept_modal1" ).click(function() {
    var service = $('input[name="services_name"]:checked')[0].value;
    var price = $("#price").val();
    if (price == undefined || price == 0) {
        alert("Nhập giá tiền");
        return false;
    }
    var data = {
        action: "add_service",
        service: service,
        price : price,
        booking_id : booking_id
    };
    $.ajax({
        url: "api/service_manager.php",
        async: false,
        success: function(){
            $("#modal1").closeModal();
            location.reload();
        },
        data : data,
        method: "POST"
    });

});
$( ".remove_service" ).click(function() {
    id = this.id.replace("close","");
        var data = {
            id: id,
            action: "remove_service"

        };
        $.ajax({
            url: "api/service_manager.php",
            async: false,
            success: function(){
                location.reload();
            },
            data : data,
            method: "POST"
        });
    
    //var service = $('input[name="services_name"]:checked')[0].value;
    //var price = $("#price").val();


});


/**
 * Get list service
 * @type {Array}
 */
var images = [];
$.ajax({
    url: "api/service_manager.php?action=getListService",
    async: false,
    success: function(result){
        images = JSON.parse(result);
        var selection ="";
        for (var i = 0 ; i<images.length; i++) {
            var service = images[i];

            selection += "<div class = \"col s4\"><input name=\"services_name\" type=\"radio\" id=\"service" + service.id + "\" value=\"" + service.id + "\" />"
                + "<label for=\"service" + service.id + "\">" + service.name + "</label></div>";
        }
        selection +="</br></br></br></br></br></br></br></br><div class=\"row input-field \">"
                    + "<input id=\"price\" type=\"number\" class=\"validate \" required>"
                    + "<label for=\"price\" >Giá tiền</label></div>";
        $("#select_services").html(selection);
    },
    method: "get"
});

var param = window.location.search.split("?")[1];
var booking_id;
$.ajax({
    url: "api/room_manager.php?action=getRoomDetail&" + param,
    async: false,
    success: function(result){
        var room = JSON.parse(result)[0];
        var status = checkRoomStatus(room);
        if (status === 0){
            $("#status").html("Không có người");
            $(".toggle").hide();
            return;

        } else if (status == 1) $("#status").html("Được đặt trước");
        else $("#status").html("Đang có người");

        getRoomDetail(room);
        getServices(room.bookingID);
        booking_id = room.bookingID;

    },
    method: "get"
});


$("td:nth-child(3)").click(function(e){
    var target = $(e.target);
    if (target.attr("id") === "edit"){
        target.parent().prev().find(".input").prop("disabled",false);
        target.parent().find("#save").show();     
        target.parent().find("#edit").hide();
    }else if (target.text() === "save"){
        var input = target.parent().prev().find("input"); 
        
        var value = "";
        if (input.attr("id") === "start_date"){
            var temp = input.val();
            var date = temp.split("/")[0];
            var month = temp.split("/")[1];
            var year = temp.split("/")[2];
            value = year + "-" + month + "-" + date;
        }else{
            value = input.val();
        }
        var data = {
            attr: input.attr("id"),
            value: value,
            user_id: $("#identity").val(),
            action: "updateDetail"
        };
        $.ajax({
            url: "api/room_manager.php",
            async: false,
            success: function(result){
        
            },
            data: data,
            method: "post"
        });
        target.parent().prev().find(".input").prop("disabled",true);
        target.parent().find("#save").hide();     
        target.parent().find("#edit").show();
    }
    
   
});


$( "#check_out" ).click(function() {
    $("#check_out_modal").openModal();
});

$( "#accept_check_out" ).click(function() {
    var booking_id = $("#booking_id").text();
    var data = {
        id: booking_id,
        action: "check_out"
    };
    $.ajax({
        url: "api/room_manager.php",
        async: false,
        success: function(){
            window.location.href="index.php";
        },
        data : data,
        method: "POST"
    });

});

$( "#change_room" ).click(function() {
    $("#change_room_modal").openModal();
});

$( "#accept_change_room" ).click(function() {
    var new_room = $('input[name="room_name"]:checked')[0].value;
    var old_room = $("#room_number").text();
    var booking_id = $("#booking_id").text();
    var data = {
        action: "changeRoom",
        newRoom: new_room,
        oldRoom: old_room,
        bookingID : booking_id
    };
    $.ajax({
        url: "api/room_manager.php",
        async: false,
        success: function(){
            $("#change_room_modal").closeModal();
            window.location.href= "room.php?id=" + new_room;

        },
        data : data,
        method: "POST"
    });

});


var rooms = [];
$.ajax({
    url: "api/room_manager.php?action=getAvailableRoom",
    async: false,
    success: function(result){
        rooms = JSON.parse(result);
        var selection ="";
        for (var i = 0 ; i<rooms.length;i++) {
            var room = rooms[i];
            selection += "<div class = \"col s4\"><input name=\"room_name\" type=\"radio\" id=\"room" + room.room_number + "\" value=\"" + room.room_number + "\" />"
                + "<label style = \"color: black;\" for=\"room" + room.room_number + "\">" + room.room_number + "</label></div>";
        }
        $("#room_select").html(selection);
    },
    method: "get"
});
