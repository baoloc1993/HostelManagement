<!DOCTYPE html>
<html lang="en">
<?php
/**
 * Created by PhpStorm.
 * User: Luis Ngo
 * Date: 4/9/2019
 * Time: 3:26 PM
 */
include("template/header.html");
?>
<body>
<!-- Material form login -->
<div class="container white" style="margin-top: 25%;">

    <h5 class="card-header info-color black-text text-center py-4">
        <strong>Tải ảnh</strong>
    </h5>

    <!--Card content-->
    <div class="card-body px-lg-5 pt-0">

        <!-- Form -->
        <div class="text-center" style="color: #757575;" method="POST">

            <!-- Name -->
            <div class="md-form">
                <label for="username">Tên khách hàng</label>
                <input type="text" id="name" class="form-control">

            </div>
            <div class="md-form">
                <label for="username">Số phòng</label>
                <input type="text" id="room" class="form-control">

            </div>

            <!-- Số phòng -->
<!--            <div class="input-field col s12" id="room_select"></div>-->
            <!-- ảnh -->
            <div class="file-field input-field">
                <div class="btn col s2">
                    <span>Ảnh</span>
                    <input type="file" id = "img_id" name="img_id">
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text">
                </div>
            </div>
            <div class="error"><?= $errorMsg ?></div>
            <button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit"
                    id="submit">Tải ảnh
            </button>
        </div>
        <!-- Form -->

    </div>

</div>
<!-- Material form login -->
<script>
    $("#submit").click(function () {
        var name = $("#name").val();
        var room = $("#room").val();
        var data = new FormData();

        data.append("name",name);
//        var room = $("#room li.active")[0].innerText
        data.append("room",room);
        data.append("img_id",files[0]);
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "api/user_gallery.php");
        xhr.send(data);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 2 || xhr.readyState === 4) {
                //var response = JSON.parse(xhr.responseText);
                if (xhr.status === 200) {
                    window.location.href = "thu_vien_anh.php";
                } else {
                    alert("upload không thành công");
                }
            }
        }
    });

    var rooms = [];
    $.ajax({
        url: "api/room_manager.php?action=getAllRooms",
        async: false,
        success: function (result) {
            rooms = JSON.parse(result);
            var selection ="<select>        " +
                "<option value=\"\" disabled selected>Chọn phòng</option>";
            for(var level=1; level <=3;level++){
                selection += "<optgroup label=\"Tầng " + level + "\">";
                for (var i = 0 ; i<rooms.length;i++) {
                    var room = rooms[i];
                    if (room.level == level) {
                        selection += "<option value=\"" + room.room_number + "\">" + room.room_number + "</option>";
                    }
                }
                selection += "</optgroup>";
            }
            selection +="</select>    <label>Chọn phòng</label>";
            $("#room_select").html(selection);
        },
        method: "get"
    });
    var files = [];
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

</script>
</body>
</html>