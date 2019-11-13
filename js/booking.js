/**
 * Created by Luis Ngo on 22/9/2017.
 */
var files = [];
$("#submit").click(function(){

    var name = $("#name").val();
    var address = $("#address").val();
    var mobile_number = $("#mobile_number").val();
    var gender = $('input[name="gender"]:checked')[0].value;

    var birthdate = $("#birthdate").val();

    var id = $("#id").val();
    if (name == ""){
        alert("Chưa điền tên khách");
        return false;
    }
    if (id == ""){
        alert("Chưa điền số chứng minh thư");
        return false;

    }
    var startDate = $("#start_date").val();
    var ss = startDate.split("-");
    startDate = ss[2]+ "-" + ss[1] + "-" + ss[0];

    var endDate = $("#end_date").val();
    ss = endDate.split("-");
    endDate = ss[2]+ "-" + ss[1] + "-" + ss[0];
    var data = new FormData();
    data.append("id",id);
    data.append("name",name);
    data.append("address",address);
    data.append("phone",mobile_number);
    data.append("gender",gender);
    data.append("birthdate",birthdate);
    data.append("bikeId",$("#bike_id").val());
    data.append("job",$("#job").val());
    data.append("deposit",$("#deposit").val());
    data.append("startDate",startDate);
    data.append("endDate",endDate);
    data.append("locker",$("#locker").val());
    var room = $("#room li.active")[0].innerText
    data.append("room",room);
    data.append("note",$("textarea#note").val());
    data.append("img_id",files[0]);
    data.append("img_person",files[1]);
    data.append("img_bike",files[2]);


    var xhr = new XMLHttpRequest();
    xhr.open("POST", "api/booking_manager.php");
    xhr.send(data);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            //var response = JSON.parse(xhr.responseText);
            if (xhr.status === 200 ) {
                alert("Đăng kí thành công");
                window.location.href= "room.php?id=" + room;
            } else {
                alert("Đăng kí không thành công");
            }
        }
    }
});

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
