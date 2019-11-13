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
                <h4 class="card-title center">Báo cáo doanh thu</h4>
            </div>

        </div>
        <div class="col s6">
            <div class="input-field inline">
                <i class="material-icons prefix">date_range</i>
                <input type="text" class="datepicker" id = "start_date">
                <label for="start_date" data-error="" data-success="">Ngày bắt đầu</label>
            </div>
        </div>
        <div class="col s6">
            <div class="input-field inline">
                <i class="material-icons prefix">date_range</i>
                <input type="text" class="datepicker" id = "end_date">
                <label for="end_date" data-error="" data-success="">Ngày kết thúc</label>
            </div>
        </div>

        <div class="input-field col s12" id="service_select">

        </div>
        <div class = "center">
            <a class="waves-effect waves-light btn " id = "submit" onclick="getServices()" >Xem báo cáo</a>
        </div>
        <div class = "row"> </div>
        <div id="service" style = "display:none">
            <div class="col s1">
                <div class="card-title"><b>STT</b></div>
            </div>
            <div class="col s4">
                <div class="card-title"><b>Tên</b></div>
            </div>
            <div class="col s3">
                <div class="card-title"><b>Giá</b></div>
            </div>

            <div class="col s3">
                <div class="card-title"><b>Ngày</b></div>
            </div>
            <div class="col s1">
                <div class="card-title"><b>Xem chi tiết</b></div>
            </div>
            <div class = "row" id="detail_service"></div>
            <div class="col s5">
                <div class="card-title"><b>Tổng cộng: </b></div>
            </div>
            <div class="col s7">
                <div class="card-title" id="total"></div>
            </div>


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
<script>
    var services = [];
    $.ajax({
        url: "api/service_manager.php?action=getListService",
        async: false,
        success: function(result){
            services = JSON.parse(result);
            var selection ="<select>        " +
                "<option value=\"\" selected>Tất cả dịch vụ-0</option>";
            for (var i = 0 ; i<services.length;i++) {
                var service = services[i];
                    selection += "<option value=\"" + service.id + "\">" + service.name + "- " + service.id + "</option>";

            }

            selection +="</select>    <label>Chọn dịch vụ</label>";
            $("#service_select").html(selection);
        },
        method: "get"
    });
    function getServices() {
        var start = $("#start_date").val();
        var st = "";
        if (start != "") {
            st = start.split("-");
            start = st[2] + "-"  + st[1] + "-" + st[0];
        }
        var end = $("#end_date").val();
        var en = "";
        if (end != "") {
            en = end.split("-");
            end = en[2] + "-"  + en[1] + "-" + en[0];
        }
        var s = $("#service_select li.active")[0];
        if (s == undefined) s = 0
        else{
            s = s.innerText;
            s = s.split("-")[1];
        }
        console.log(s);

        $.ajax({
            url: "api/service_manager.php?action=getServices",
            async: false,
            success: function(result){

                var services = JSON.parse(result);
                var serviceHTML = "";
                var sum = 0;
                for (var i= 0 ; i<services.length;i++){
                    $("#service").show();
                    var service = services[i];
                    serviceHTML +="<div class=\"col s1\"><div class=\"card-title\">"+ (i+1) + "</div> </div>";
                    serviceHTML +="<div class=\"col s4\"><div class=\"card-title\">"+ service.name + "</div> </div>";
                    serviceHTML +="<div class=\"col s3\"><div class=\"card-title\">"+ service.price + "</div> </div>";
                    serviceHTML +="<div class=\"col s3\"><div class=\"card-title\">"+ service.date + "</div> </div>";
                    serviceHTML +="<div class=\"col s1\"><div class=\"card-title\" style = \"cursor:pointer;\" onclick=\"getBooking(this)\" id=\""+service.booking_id +"\"><i class=\"material-icons\" onclick = \"\">pageview</i></div> </div>";
                    sum += parseInt(service.price);
                }
                $("#detail_service").html( serviceHTML);
                $("#total").html("<b>" + sum + "</b>");


            },
            data : {
                id : s,
                startDate : start,
                endDate : end
            },
            method: "get"
        });
    }
    
    
    function getBooking(element) {
        var id = $(element).attr("id");
        window.location.href = "room_view.php?bookingId=" + id;
    }
</script>
</html>