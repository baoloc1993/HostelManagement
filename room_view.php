
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
<link rel="stylesheet" type="text/css" href="css/room.css">
<body>
<?php include("template/navigation_bar.html");?>
<div class="row">
    <!-- Title -->
    <div class="col s12 m10 offset-l1">
        <div class = "row">
            <div class="col s12  center">
                <h4 class="card-title">Phòng <?php echo $_GET["id"]?></h4>
            </div>
        </div>
        <table class = "highlight">
            <tbody>
              <tr class = "toggle">
                <td><b>Tên người sử dụng:</b></td>
                <td><input disabled value="" id="name" type="text"></td>
              </tr>
              <tr class = toggle>
                <td><b>Ngày bắt đầu:</b></td>
                <td><input disabled value="" id="start_date" type="text"></td>
              </tr>
              <tr class = toggle>
                <td><b>Ngày kết thúc:</b></td>
                <td><input disabled value="" id="end_date" type="text"></td>
              </tr>
               <tr class = toggle>
                <td><b>Địa chỉ:</b></td>
                <td><input disabled value="" id="address" type="text"></td>
              </tr>
               <tr class = toggle>
                <td><b>Giới tính:</b></td>
                <td><input disabled value="" id="gender" type="text"></td>
              </tr>
               <tr class = toggle>
                <td><b>Số điện thoại:</b></td>
                <td><input disabled value="" id="mobile" type="text"></td>
              </tr>
               <tr class = toggle>
                <td><b>Số thẻ:</b></td>
                <td><input disabled value="" id="locker" type="text"></td>
              </tr>
               <tr class = toggle>
                <td><b>Số chứng minh:</b></td>
                <td><input disabled value="" id="identity" type="text"></td>
              </tr>
               <tr class = toggle>
                <td><b>Biển số xe:</b></td>
                <td><input disabled value="" id="bike_id" type="text"></td>
              </tr>
               <tr class = toggle>
                <td><b>Nghề nghiệp:</b></td>
                <td><input disabled value="" id="job" type="text"></td>
              </tr>
               <tr class = toggle>
                <td><b>Ghi chú:</b></td>
                <td><input disabled value="" id="note" type="text"></td>
              </tr>
            </tbody>
        </table>

        <hr>
        <div id="service" style = "display:none">
            <div class = "row">
                <div class="col s12 center">
                    <h3 class="card-title">Dịch vụ</h3>
                </div>
            </div>
            <div class="col s4">
                <div class="card-title"><b>Tên</b></div>
            </div>
            <div class="col s3">
                <div class="card-title"><b>Giá</b></div>
            </div>
            <div class="col s4">
                <div class="card-title"><b>Ngày</b></div>
            </div>
            <div clas = "row" id="detail_service"></div>
            <div class="col s4">
                <div class="card-title"><b>Tổng cộng: </b></div>
            </div>
            <div class="col s8">
                <div class="card-title" id="total"></div>
            </div>
        </div>
        <div class = "row"></div>
        <hr>
        <!--Ảnh-->
        <div id="image" style = "display:none">
            <div class = "row">
                <div class="col s12 center ">
                    <h4 class="card-title">Ảnh</h4>
                </div>
            </div>
            <div class="col s12">
                <img class="card-title" src="" id="img_id">
            </div>
            <div class="col s12">
                <img class="card-title" src="" id="img_person">
            </div>
            <div class="col s12">
                <img class="card-title" src="" id="img_bike">
            </div>
        </div>

    </div>
</div>
<script src = "js/room-common.js"></script>
<script src = "js/room_view.js"></script>

</body>
</html>