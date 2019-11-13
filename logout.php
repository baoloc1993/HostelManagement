<?php
session_start();


$_SESSION["login"] = NULL;
    echo "<script>window.location = 'login.php'</script>";
?>