<?php
session_start();
if($_SESSION["login"] === NULL){
    echo "<script>window.location = 'login.php'</script>";
};

?>