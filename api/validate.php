<?php
session_start();

require_once ("config.php");
// Create connection
$conn = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD,MYSQL_DATABASE);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$errorMsg = "";
$validUser = $_SESSION["login"] === true;

$validUser = checkPassword($conn,$_POST["username"], $_POST["password"]);
if(!$validUser){
  $errorMsg = "Invalid username or password.";
    print json_encode (0);
}else {
    $_SESSION["login"] = true;
    print json_encode (1);
}



function checkPassword($conn,$username,$password)
{
    $query = "SELECT COUNT(*) FROM  `hostel_admin` WHERE `username` = '$username' and `password` = '$password'";
    $result = $conn->query($query);
    $rows = array();
    while ($r = mysqli_fetch_assoc($result)) {
        $rows[] = $r;
    }
    
    if ($rows[0]["COUNT(*)"] === "1") return true;
    else return false;

}
?>