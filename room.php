
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
<link rel="stylesheet" type="text/css" href="css/room.css">
<body>
<?php include("template/navigation_bar.html");?>
    <div class="row">
        <!-- Title -->
        <div class="col s12 m10 offset-l1">
            <div class = "row">
                <div class="col s12  center">
                    <a style = "display :none" id = "room_number"><?php echo $_GET["id"]?></a>
                    <a style = "display :none" id = "booking_id"></a>

                    <h4 class="card-title">Phòng <?php echo $_GET["id"]?></h4>
                </div>
            </div>
            <table class = "highlight">
                <tbody>
                  <tr>
                    <td><b>Trạng thái:</b></td>
                    <td id = "status"></td>
                  </tr>
                  <tr class = "toggle">
                    <td><b>Tên người sử dụng:</b></td>
                    <td><input disabled value="" id="name" type="text" class = "input"></td>
                    <td><i id = "edit" class="material-icons">edit</i><i id = "save" style = "display:none" class="material-icons ">save</i></td>
                  </tr>
                  <tr class = toggle>
                    <td><b>Ngày bắt đầu:</b></td>
                    <td><input disabled value="" id="start_date" type="text" class = "input"></td>
                    <td><i id = "edit" class="material-icons">edit</i><i id = "save" style = "display:none" class="material-icons ">save</i></td>
                  </tr>
                   <tr class = toggle>
                    <td><b>Địa chỉ:</b></td>
                    <td><input disabled value="" id="address" type="text" class = "input"></td>
                    <td><i id = "edit" class="material-icons">edit</i><i id = "save" style = "display:none" class="material-icons ">save</i></td>
                  </tr>
                   <tr class = toggle>
                    <td><b>Giới tính:</b></td>
                    <td><input disabled value="" id="gender" type="text" class = "input"></td>
                    <td><i id = "edit" class="material-icons">edit</i><i id = "save" style = "display:none" class="material-icons ">save</i></td>
                  </tr>
                   <tr class = toggle>
                    <td><b>Số điện thoại:</b></td>
                    <td><input disabled value="" id="mobile" type="text" class = "input"></td>
                    <td><i id = "edit" class="material-icons">edit</i><i id = "save" style = "display:none" class="material-icons ">save</i></td>
                  </tr>
                   <tr class = toggle>
                    <td><b>Số thẻ:</b></td>
                    <td><input disabled value="" id="locker" type="text" class = "input"></td>
                    <td><i id = "edit" class="material-icons">edit</i><i id = "save" style = "display:none" class="material-icons ">save</i></td>
                  </tr>
                   <tr class = toggle>
                    <td><b>Số chứng minh:</b></td>
                    <td><input disabled value="" id="identity" type="text" class = "input"></td>
                    <td><i id = "edit" class="material-icons">edit</i><i id = "save" style = "display:none" class="material-icons ">save</i></td>
                  </tr>
                   <tr class = toggle>
                    <td><b>Biển số xe:</b></td>
                    <td><input disabled value="" id="bike_id" type="text" class = "input"></td>
                    <td><i id = "edit" class="material-icons">edit</i><i id = "save" style = "display:none" class="material-icons ">save</i></td>
                  </tr>
                   <tr class = toggle>
                    <td><b>Nghề nghiệp:</b></td>
                    <td><input disabled value="" id="job" type="text" class = "input"></td>
                    <td><i id = "edit" class="material-icons">edit</i><i id = "save" style = "display:none" class="material-icons ">save</i></td>
                  </tr>
                   <tr class = toggle>
                    <td><b>Ghi chú:</b></td>
                    <td><textarea disabled value="" id="note" type="text" class = "materialize-textarea input"></textarea></td>
                    <td><i id = "edit" class="material-icons">edit</i><i id = "save" style = "display:none" class="material-icons ">save</i></td>
                  </tr>
                </tbody>
            </table>
            <div class="col s12 center" >
                <a style = "display: none" class="waves-effect waves-light btn modal-trigger action_room" id="check_out" value="" href="#check_out_modal" >Trả phòng</a>
                <a style = "display: none" class=" waves-effect waves-light btn modal-trigger action_room" id="change_room" href="#change_room_modal">Chuyển phòng</a>
            </div>
            <!-- Change room modal -->
            <div id="change_room_modal" class="modal">
                <div class="modal-content">
                    <div class=" modal-header center">
                        <h4>Chuyển phòng</h4>
                    </div>


                    <div class="modal-body" id ="room_select">

                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Hủy</a>
                    <a id = "accept_change_room" href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Đồng Ý</a>

                </div>
            </div>
            <!-- check out modal -->
            <div id="check_out_modal" class="modal">
                <div class="modal-content">
                    <div class=" modal-header center">
                        <h4>Trả phòng</h4>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Hủy</a>
                    <a id = "accept_check_out" href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Đồng Ý</a>

                </div>
            </div>
            <div class = "row"></div>
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
                <div class="col s1">
                    <div class="card-title"><b></b></div>
                </div>
                <div class = "row" id="detail_service"></div>
                <div class="col s4">
                    <div class="card-title"><b>Tổng cộng: </b></div>
                </div>
                <div class="col s8">
                    <div class="card-title" id="total"></div>
                </div>

                <!-- Modal Trigger -->
                <div class = "col s12 center">
                    <a class=" waves-effect waves-light btn modal-trigger" id="add_service" href="#modal1">Thêm dịch vụ</a>
                </div>

                <!-- Modal Structure -->
                <div id="modal1" class="modal">
                    <div class="modal-content">
                        <div class=" modal-header center">
                            <h4>Thêm dịch vụ</h4>
                        </div>


                        <div class="modal-body" id ="select_services">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Hủy</a>
                        <a id = "accept_modal1" href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Đồng Ý</a>

                    </div>
                </div>
            </div>
            <div class = "row"></div>

            <hr>
            <!--Ảnh-->
            <div id="image" style = "display:none">
                <div class = "row">
                    <div class="col s12 center ">
                        <h3 class="card-title">Ảnh</h3>
                    </div>
                </div>
                <div class="col s12" id = "img_id_container">
                    <img class="card-title" src="" id="img_id">
                    <div class="file-field input-field" style = "display:none;">
                        <div class="btn col s2">
                            <span>Ảnh</span>
                            <input type="file" id = "img_id" name="img_id">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>
                </div>
                <div class="col s12" id = "img_person_container">
                    <img class="card-title" src="" id="img_person">
                    <div class="file-field input-field" style = "display:none;">
                        <div class="btn col s2">
                            <span>Ảnh</span>
                            <input type="file" id = "img_person" name="img_person">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>
                </div>
                <div class="col s12" id = "img_bike_container">
                    <img class="card-title" src="" id="img_bike">
                    <div class="file-field input-field " style = "display:none">
                        <div class="btn col s2">
                            <span>Ảnh</span>
                            <input type="file" id = "img_bike" name="img_bike">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>
                </div>
                <a class="waves-effect waves-light btn" id = "img-submit" style = "display:none;">Xác nhận</a>
            </div>

        </div>
    </div>
                    <img class="card-title" src="" id="output">
    <script src = "js/room-common.js"></script>
    <script src = "js/room.js"></script>

</body>
</html>