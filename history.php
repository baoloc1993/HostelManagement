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
    <div class="col s12 m4 offset-l4">
        <div class="row center">
            <h4>Lịch sử đặt phòng</h4>
        </div>

    </div>
    <div class="col s12 m10 offset-l1">
        <?php include("template/search_form.html");?>

    </div>
    <div class = "row"></div>
    <hr>
    <div class="col s12 m10 offset-l1">
        <div class = "row">
            <div class="col s12 center ">
                <h5 class="card-title">Kết quả</h5>
            </div>
        </div>
        <div class="col s3">
            <div class="card-title"><b>Tên</b></div>
        </div>
        <div class="col s2">
            <div class="card-title"><b>Số phòng</b></div>
        </div>
        <div class="col s3">
            <div class="card-title"><b>Ngày bắt đầu</b></div>
        </div>
        <div class="col s3">
            <div class="card-title"><b>Ngày kết thúc</b></div>
        </div>
        <div id ="search_detail"></div>


    </div>
</div>
<script>
    function genResult(result) {
        var results = JSON.parse(result);
        var innerHtml = "";
        for (var i = 0 ; i < results.length; i++){
            var r = results[i];
            innerHtml += "<div class=\"room_detail row\" id=\"room_detail"+r.booking_id + "\">";
            innerHtml += "<div class=\"col s3\"><div class=\"card-title\">" + r.name + "</div></div>";
            innerHtml += "<div class=\"col s2\"><div class=\"card-title\">" + r.room_id + "</div></div>";
            innerHtml += "<div class=\"col s3\"><div class=\"card-title\">" + r.start_date + "</div></div>";
            innerHtml += "<div class=\"col s3\"><div class=\"card-title\">" + r.end_date + "</div></div>";
            innerHtml += "<div style = \"cursor: pointer; \" class=\"col s1\" onclick=\"getBooking(this)\" id=\""+r.booking_id +"\"><i class=\"material-icons prefix\">pageview</i> </div></div>";


        }
        $("#search_detail").html(innerHtml);
    }
    $( "#submit" ).click(function() {
        var gender ="";
        if ($('input[name="search_gender"]:checked')[0] != undefined){
            gender = $('input[name="search_gender"]:checked')[0].value;
        }

        var startDate = $("#search_startDate").val();
        console.log(startDate);
        if (startDate !="" ){
            var ss = startDate.split("-");
            startDate = ss[2]+ "-" + ss[1] + "-" + ss[0];
        }


        var endDate = $("#search_endDate").val();

        if (endDate !="" ){
            ss = endDate.split("-");
            endDate = ss[2] + "-" + ss[1] + "-" + ss[0];
        }
        var data = {
            action: "search",
            gender: gender,
            name : $("#search_name").val(),
            address : $("#address").val(),
            roomNo : $("#search_room").val(),
            id : $("#id").val(),
            start: startDate,
            end : endDate
        };
        $.ajax({
            url: "api/room_manager.php",
            async: false,
            success: function(result){
                genResult(result);
            },
            data : data,
            method: "GET"
        });

    });
    function getBooking(element) {
        var id = $(element).attr("id");
        window.location.href = "room_view.php?bookingId=" + id;
    }

</script>
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
</body>
</html>
