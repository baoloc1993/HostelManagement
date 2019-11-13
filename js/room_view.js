/**
 * Created by Luis Ngo on 22/9/2017.
 */

function handleImg(room) {
    $("#img_id").attr("src",room.img_id);
    $("#img_person").attr("src",room.img_person);
    $("#img_bike").attr("src",room.img_bike);
}

var param = window.location.search.split("?")[1];
$.ajax({
    url: "api/room_manager.php?action=viewRoom&"+ param,
    async: false,
    success: function(result){
        var room = JSON.parse(result)[0];
        getRoomDetail(room);
        getServices(room.bookingID);
        booking_id = room.bookingID;

    },
    method: "get"
});
