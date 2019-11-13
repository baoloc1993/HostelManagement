<!DOCTYPE html>
<html lang="en">
<?php
/**
 * Created by PhpStorm.
 * User: Luis Ngo
 * Date: 17/9/2017
 * Time: 3:26 PM
 */
require_once("api/check_login.php");
include("template/header.html");
?>
<body>
<?php include("template/navigation_bar.html");?>
<div class="row">
    <div class="col s12 m4 offset-l4">
        <div class="row center">
            <h4>Quản lý phòng</h4>
        </div>
        <div id = "test"></div>

    </div>
    <div class="col s12 m10 offset-l1">
        <div class="row">
            <div class="col s12">
                <ul class="tabs">
                    <li class="tab col s6"><a href="#level2" class = "active">Tầng 2</a></li>
                    <li class="tab col s6"><a href="#level3">Tầng 3</a></li>

                </ul>
            </div>


        </div>
        <div id ="rooms">
        </div>

    </div>
</div>
<script>
    $.ajax({
        url: "api/room_manager.php?action=getRoom",
        async: false,
        success: function(result){
            rooms = JSON.parse(result);
//            console.log(rooms);
            var selection ="";
            for(var level=2; level <=3;level++){
                selection += "<div id=\"level"+level +"\" class=\"row\">" +
                    "<ul class=\"collection\">";
                for (var i = 0 ; i<rooms.length;i++) {
                    var room = rooms[i];
                    if (room.level == level) {
                        selection +="<li class=\"collection-item avatar\" id = \"" + room.room_number + "\" style = \"cursor: pointer;\">";
                        var status = checkRoomStatus(room);
                        if (status == 0){
                            selection += "<i class=\"material-icons circle green\">done</i>"
                                        + "<span class=\"title\">Phòng " + room.room_number + "</span>"
                                        + "<p>Đang trống<br></p>"

                        }else if (status == 1){
                            selection += "<i class=\"material-icons circle yellow\">more_horiz</i>"
                                        + "<span class=\"title\">Phòng " + room.room_number + "</span>"
                                        + "<p>Được đặt trước<br></p>"
                        }else{
                            selection += "<i class=\"material-icons circle red\">close</i>"
                                            + "<span class=\"title\">Phòng " + room.room_number + "</span>"
                                             + "<p>Đang có người<br></p>";
                        }
                        selection += "</li>"

                    }
                }
                selection += "</ul></div>";
            }
            $("#rooms").html(selection);
        },
        method: "get"
    });

    $(".collection-item").click(function(){
        var id = $(this).attr('id');
        window.location = 'room.php?id='+id;

    });

</script>
</body>
</html>
