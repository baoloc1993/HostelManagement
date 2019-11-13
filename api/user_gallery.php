<?php
/**
 * Created by PhpStorm.
 * User: Luis Ngo
 * Date: 18/9/2019
 * Time: 6:33 PM
 */
require_once ("config.php");
$name = $_POST["name"];
$room = $_POST["room"];

$target_dir = "../img/user/";


/*
 * Upload imgId
 */

if($_FILES["img_id"]!=NULL) {
    $target_file_id = $target_dir . time() . ".jpg";
    $type = substr($_FILES["img_id"]["name"],-3,3);
    $resize_des = uploadImage($_FILES["img_id"]["tmp_name"],$target_file_id,$type);

}else{
    $target_file_id = "";

}




// Create connection
$conn = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD,MYSQL_DATABASE);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
function addToDatabase($name,$room,$img_id){

    $img_id = substr($img_id,3);
    global $conn;
    /*
     * Add user
     */
    $query = "INSERT INTO `hostel_user_gallery` (`name`, `room`, `img`)
                VALUES ('$name ', $room,'$img_id') ";
    $conn->query($query);
    $conn->commit();
//    $conn->close();
    return;

}

function getGallery(){

    global $conn;
    /*
     * Add user
     */
    $query = "SELECT * FROM `hostel_user_gallery` ORDER BY `id` DESC";

    $result = $conn->query($query);
    $rows = array();
    while ($r = mysqli_fetch_assoc($result)) {
        $rows[] = $r;
    }
    print json_encode($rows);
    $conn->close();

}

function uploadImage($image, $target_file,$type) {
    $imageSize = getImageSize($image);
    $imageWidth = $imageSize[0];
    $imageHeight = $imageSize[1];

    $DESIRED_WIDTH = 500;
    $new_width = $DESIRED_WIDTH;
    $new_height =  ceil($new_width* $imageHeight / $imageWidth);
    $image_p = imagecreatetruecolor($new_width, $new_height);
    $imageSource = null;
    if ($type == "png"){
        $imageSource = imagecreatefrompng($image);

    }else{
        $imageSource = imagecreatefromjpeg($image);
    }
    imagecopyresampled($image_p, $imageSource, 0, 0, 0, 0, $new_width, $new_height, $imageWidth, $imageHeight);
    imagejpeg($image_p, $target_file, 100);

}
if (sizeof($_GET)>0) {
    getGallery();
}

if (sizeof($_POST)>0) {
    addToDatabase($name,$room,$target_file_id);
}
