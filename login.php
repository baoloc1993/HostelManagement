<!DOCTYPE html>
<html lang="en">
<?php
/**
 * Created by PhpStorm.
 * User: Luis Ngo
 * Date: 4/9/2018
 * Time: 3:26 PM
 */
include("template/header.html");
?>
<body>
  <!-- Material form login -->
<div class="container white" style = "margin-top: 25%;">

  <h5 class="card-header info-color black-text text-center py-4">
    <strong>Đăng nhập</strong>
  </h5>

  <!--Card content-->
  <div class="card-body px-lg-5 pt-0">

    <!-- Form -->
    <div class="text-center" style="color: #757575;" method = "POST">

      <!-- Email -->
      <div class="md-form">
        <input type="text" id="username" class="form-control">
        <label for="username">Tên đăng nhập</label>
      </div>

      <!-- Password -->
      <div class="md-form">
        <input type="password" id="password" class="form-control">
        <label for="password">Mật khẩu</label>
      </div>
      <!-- Sign in button -->
      <div class="error"><?= $errorMsg ?></div>
      <button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit" id = "submit">Đăng nhập</button>
    </div>
    <!-- Form -->

  </div>

</div>
<!-- Material form login -->
<script>
    $("#submit").click(function(){

    var username = $("#username").val();
    var password = $("#password").val();
    var submit = $("#submit").val();
    var data = new FormData();
    data.append("username",username);
    data.append("password",password);
    data.append("submit",submit);
    console.log(username);
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "api/validate.php");
    xhr.send(data);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            //var response = JSON.parse(xhr.responseText);
            if (xhr.status === 200 && xhr.responseText === "1") {
                window.location.href= "index.php";
            } else {
                alert("Đăng nhập không thành công");
            }
        }
    }
});
</script>
</body>
</html>