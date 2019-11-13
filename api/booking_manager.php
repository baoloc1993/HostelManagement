<?php
/**
 * Created by PhpStorm.
 * User: Luis Ngo
 * Date: 18/9/2017
 * Time: 6:33 PM
 */
require_once ("config.php");
$name = $_POST["name"];
$address = $_POST["address"];
$phone_number = $_POST["phone"];
$gender = $_POST["gender"];
$birthdate = $_POST["birthdate"];
$id  = $_POST["id"];
$email = "";
$bikeId = $_POST["bikeId"];
$job = $_POST["job"];
$deposit = $_POST["deposit"];
$startDate = $_POST["startDate"];
$endDate = $_POST["endDate"];
$room = $_POST["room"];
$note = $_POST["note"];
$locker = $_POST["locker"];
if(!in_array("locker",$_POST)) $locker= 0;

$target_dir = "../img/uploads/$id";
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

var_dump($_FILES["img_i"]==NULL);
/*
 * Upload imgId
 */
 
if($_FILES["img_id"]!=NULL) {
    $target_file_id = $target_dir . "/img_id.jpg";
    $type = substr($_FILES["img_id"]["name"],-3,3);
    $resize_des = uploadImage($_FILES["img_id"]["tmp_name"],$target_file_id,$type);

}else{
    $target_file_id = "";

}

var_dump($target_file_id);
/*
 * Upload img_person
 */
if($_FILES["img_person"]!=NULL) {

    $target_file_person = $target_dir . "/img_person.jpg";
    $type = substr($_FILES["img_person"]["name"], -3, 3);
    $resize_des = uploadImage($_FILES["img_person"]["tmp_name"], $target_file_person, $type);
}else{
    $target_file_person = "";

}
/*
 * Upload img_bike
 */
if($_FILES["img_bike"]!=NULL) {
    $target_file_bike = $target_dir . "/img_bike.jpg";
    $type = substr($_FILES["img_bike"]["name"],-3,3);
    $resize_des = uploadImage($_FILES["img_bike"]["tmp_name"],$target_file_bike,$type);
}else{
    $target_file_bike = "";

}


// Create connection
$conn = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD,MYSQL_DATABASE);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
function addToDatabase($id,$name,$address,$phone_number,$gender,$birthdate,$email,$bikeId,$job,$deposit,$startDate,$endDate,$room, $note,$locker,$img_id,$img_person,$img_bike){
    
    $img_id = substr($img_id,3);
    $img_bike = substr($img_bike,3);
    $img_person  = substr($img_person,3);
    global $conn;
    /*
     * Add user
     */
    $query = "INSERT INTO `hostel_user` (`id`, `name`, `phone_number`, `gender`, `email`, `bike_id`, `job`, `address`,`birthdate`,`img_id`,`img_person`,`img_bike`)
                VALUES ('$id', '$name', '$phone_number', '$gender', '$email', '$bikeId', '$job', '$address',DATE('$birthdate'),'$img_id','$img_person','$img_bike') ";
                var_dump($query);
//    mysqli_query($conn,$query);

    /*
     * Add booking
     */
    $query2 = "INSERT INTO `hostel_booking` ( `room_id`, `user_id`, `start_date`, `end_date`, `note`, `deposit`,`locker`) VALUES
                ('$room', '$id',DATE('$startDate'), DATE('$endDate'), '$note', $deposit,$locker)";
//    var_dump($query, $query2);
//     $conn->begin_transaction();
    $conn->query($query);
    $conn->query($query2);
     $conn->commit();
//    $conn->close();
    return;

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
addToDatabase($id,$name,$address,$phone_number,$gender,$birthdate,$email,$bikeId,$job,$deposit,$startDate,$endDate,$room,$note,$locker,$target_file_id,$target_file_person,$target_file_bike);