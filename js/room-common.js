/**
 * Created by Luis Ngo on 22/9/2017.
 */
 
var files = [];


function getRoomDetail(room) {
    $("#name").val(room.name);
    var start_date = new Date(room.start_date);
    $("#start_date").val(start_date.getDate() +  "/" + (start_date.getMonth()+1) + "/" + start_date.getFullYear());
    if (room.end_date === 0){
		$("#end_date").val("Chưa xác định ");
	}else{
		var end_date = new Date(room.end_date);
		$("#end_date").val(end_date.getDate() +  "/" + (end_date.getMonth()+1) + "/" + end_date.getFullYear());
    }
    $("#address").val(room.address);
    var g = "Nam";
    if (room.gender === 0) g = "Nữ";
    $("#gender").val(g);
    $("#mobile").val(room.phone_number);
    $("#locker").val(room.locker);
    $("#identity").val(room.id);
    $("#bike_id").val(room.bike_id);
    $("#job").val(room.job);
    $("#note").val(room.note);
    handleImg(room);
    $("#booking_id").text(room.bookingID);
    $("#check_out").attr("value",room.bookingID);
    $(".toggle > td").attr("height","10");

}

function getServices(bookingId) {
    $("#service").show();
    $("#image").show();
    $(".action_room").show();

    $.ajax({
        url: "api/service_manager.php?action=getServices&bookingId="+ bookingId,
        async: false,
        success: function(result){
            var services = JSON.parse(result);
            var serviceHTML = "";
            var sum = 0;
            for (var i= 0 ; i<services.length;i++){
                var service = services[i];
                serviceHTML +="<div class=\"col s4\"><div class=\"card-title\">"+ service.name + "</div> </div>";
                serviceHTML +="<div class=\"col s3\"><div class=\"card-title\">"+ service.price + "</div> </div>";
                serviceHTML +="<div class=\"col s4\"><div class=\"card-title\">"+ service.date + "</div> </div>";
                serviceHTML +="<div class=\"col s1 remove_service\" id =\"close"+ service.id + "\" style =\"cursor:pointer;\"><i class=\"material-icons prefix\">clear</i></div>";
                sum += parseInt(service.price);
            }
            $("#detail_service").html( serviceHTML);
            $("#total").html("<b>" + sum + "</b>");
        },
        method: "get"
    });
}

