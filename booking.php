<!DOCTYPE html>
<html lang="en">
<?php
/**
 * Created by PhpStorm.
 * User: Luis Ngo
 * Date: 17/9/2017
 * Time: 3:26 PM
 */
include("template/header.html");
require_once("api/check_login.php");
?>
<body>
<?php include("template/navigation_bar.html");?>
<div class="row">
    <!-- Title -->
    <div class="col s12 m10 offset-l1">
        <div class = "row">
            <div class="col s12 center">
                <h4 class="card-title center">Thông tin đặt phòng</h4>
            </div>

        </div>
        <div class="row">
            <div class="col s12">
                <ul class="tabs">
                    <li class="tab col s3"><a href="#personal" class = "active">Bắt buộc</a></li>
                    <li class="tab col s3"><a href="#details">Chi tiết</a></li>
                    <li class="tab col s3"><a href="#room">Phòng</a></li>
                    <li class="tab col s3"><a href="#note">Ghi chú</a></li>
                </ul>
            </div>


        </div>
        <!-- Form -->
        <div id="personal" class="row">
            <?php include ("template/personal.html");?>
        </div>
        <div id="details" class="row">
            <?php include ("template/details.html");?>
        </div>
        <div id="room" class="row">
            <?php include("template/add_room.html");?>
        </div>
        <div id="note" class="row">
            <?php include ("template/note.html");?>

        </div>

    </div>

</div>

</body>
<script>
    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 200, // Creates a dropdown of 15 years to control year,
        monthsFull: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
        weekdaysShort: ['Chủ Nhật', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'],
        today: 'Hôm nay',
        clear: 'Xóa',
        close: 'Ok',
        format:'dd-mm-yyyy',
        closeOnSelect: true // Close upon selecting a date,
    });
    $(document).ready(function() {
        $('select').material_select();
    });

</script>
</html>