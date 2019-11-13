<?php
/**
 * Created by PhpStorm.
 * User: Luis Ngo
 * Date: 20/9/2017
 * Time: 10:41 PM
 */
require_once ("config.php");
// Create connection
$conn = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD,MYSQL_DATABASE);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/**
 * @param $conn
 */
function getAvailableRooms($conn)
{
    $query = "SELECT `hostel_room`.* FROM `hostel_room` WHERE `hostel_room`.`id` NOT IN (
                SELECT DISTINCT `hostel_booking`.`room_id` FROM `hostel_booking`
                  WHERE `hostel_booking`.`end_date` IS NULL OR `hostel_booking`.`end_date` > CURRENT_TIME() ) ORDER BY `hostel_room`.`id`";
//    var_dump($query);
    $result = $conn->query($query);
    $rows = array();
    while ($r = mysqli_fetch_assoc($result)) {
        $rows[] = $r;
    }
    print json_encode($rows);
}

/**
 * @param $conn
 */
function getAllRooms($conn)
{
    $query = "SELECT * FROM `hostel_room`";
    var_dump($query);
    $result = $conn->query($query);
    $rows = array();
    while ($r = mysqli_fetch_assoc($result)) {
        $rows[] = $r;
    }
    print json_encode($rows);
}

/**
 * @param $conn
 */
function getRooms($conn)
{
    $query = "SELECT `hostel_room`.`room_number`,`hostel_room`.`level`, temp2.* FROM `hostel_room` LEFT JOIN
                (SELECT `hostel_user`.`name` , temp.room_id, temp.start_date, temp.end_date,temp.id FROM `hostel_user` INNER JOIN
                  (SELECT a.`id`,a.`room_id`,a.`user_id`, a.`start_date`,a.`end_date` FROM `hostel_booking` a INNER JOIN
                    (SELECT `room_id`, MAX(`hostel_booking`.`id`) as max_id FROM `hostel_booking`
                      GROUP BY `hostel_booking`.`room_id`) temp2 ON a.`id` = temp2.max_id) AS temp ON hostel_user.id = temp.user_id) AS temp2 ON `hostel_room`.`id` = temp2.`room_id` ORDER BY `hostel_room`.`room_number`";
    $result = $conn->query($query);
    $rows = array();
    while ($r = mysqli_fetch_assoc($result)) {
        $r['start_date'] = strtotime( $r['start_date']) * 1000;
        $r['end_date'] = strtotime( $r['end_date']) * 1000;
        $rows[] = $r;
    }
    
    
    print json_encode($rows);
}

/**
 * @param $conn
 */
function getRoomDetail($conn,$roomId,$bookingId)
{
    if ($bookingId != NULL){
        $query = "SELECT start_date, end_date, note, room_id, locker, `hostel_user`.* FROM `hostel_user` INNER JOIN
                    (SELECT `user_id`,`start_date`, `end_date`, `note`,`room_id`, id as booking_id,locker
                        FROM `hostel_booking`) as temp ON temp.`user_id` = `hostel_user`.`id`
                          WHERE booking_id = $bookingId";
                var_dump($query);

    }else{
        $query = "SELECT temp.* , `hostel_user`.* FROM `hostel_user` INNER JOIN
                (SELECT `user_id`,`id` as bookingID, `start_date`, `end_date`, `note`, `deposit`,`room_id`, locker
                    FROM `hostel_booking` WHERE `id` = (SELECT MAX(`id`) FROM `hostel_booking` GROUP BY `room_id` HAVING room_id = $roomId)) as temp
              ON temp.`user_id` = `hostel_user`.`id`";

    }
    $result = $conn->query($query);
    $rows = array();
    while ($r = mysqli_fetch_assoc($result)) {
        $r['start_date'] = strtotime( $r['start_date']) * 1000;
        $r['end_date'] = strtotime( $r['end_date']) * 1000;
        $rows[] = $r;
    }
    print json_encode($rows);
}

/**
 * @param $conn
 */
function viewRoom($conn,$bookingId)
{
 
    $query = "SELECT start_date, end_date, note, room_id, locker, booking_id as bookingID, `hostel_user`.* FROM `hostel_user` INNER JOIN
                (SELECT `user_id`,`start_date`, `end_date`, `note`,`room_id`, id as booking_id,locker
                    FROM `hostel_booking`) as temp ON temp.`user_id` = `hostel_user`.`id`
                      WHERE booking_id = $bookingId";

    $result = $conn->query($query);
    $rows = array();
    while ($r = mysqli_fetch_assoc($result)) {
        $r['start_date'] = strtotime( $r['start_date']) * 1000;
        $r['end_date'] = strtotime( $r['end_date']) * 1000;
        $rows[] = $r;
    }
    print json_encode($rows);
}

function getRoomDetail2($conn,$bookingId)
{
    $query = "SELECT temp.room_id  FROM `hostel_user` INNER JOIN
                (SELECT `user_id`,`room_id`, id as booking_id
                    FROM `hostel_booking` ) as temp
              ON temp.`user_id` = `hostel_user`.`id` WHERE temp.`booking_id`=$bookingId";
    $result = $conn->query($query);
    $rows = array();
    while ($r = mysqli_fetch_assoc($result)) {
        $r['start_date'] = strtotime( $r['start_date']) * 1000;
        $r['end_date'] = strtotime( $r['end_date']) * 1000;
        $rows[] = $r;
    }
    print json_encode($rows);
}



/**
 * @param $conn
 * Search room detail
 */
function search($conn)
{
    $name = $_GET["name"];
    $address = $_GET["address"];

    $where = " WHERE `hostel_user`.`name` LIKE '%$name%' AND `hostel_user`.`address` LIKE '%$address%' ";
    if (in_array("roomNo",$_GET) || $_GET["roomNo"] != ""){
        $roomNumber = $_GET["roomNo"];
        $where .= " AND `room_id`=$roomNumber";

    }
    if (in_array("id",$_GET) || $_GET["id"] != "" ){
        $id = $_GET["id"];
        $where .= " AND `hostel_user`.`id` = $id ";

    }
    if (in_array("start",$_GET) || $_GET["start"] != ""){
        $start = $_GET["start"];
        $where .= " AND `start_date` = $start ";

    }
    if (in_array("end",$_GET) || $_GET["end"] != ""){
        $end = $_GET["end"];
        $where .= " AND `end_date` = $end ";

    }

    if (in_array("gender",$_GET) || $_GET["gender"] != ""){
        $gender = $_GET["gender"];
        $where .= " AND `hoster_user`.`gender` = $gender ";

    }
//    if ($name)
    $query = "SELECT `start_date`, `end_date`, `room_id`, `hostel_booking`.id as booking_id, `hostel_user`.name
                FROM `hostel_user` INNER JOIN `hostel_booking` ON `user_id` = `hostel_user`.`id` $where ORDER BY `start_date`";
//  var_dump($query);
    $result = $conn->query($query);
    $rows = array();
//    var_dump($result);
    while ($r = mysqli_fetch_assoc($result)) {
        $rows[] = $r;
    }
    print json_encode($rows);

}

if (sizeof($_GET)>0){
    $action = $_GET["action"];
    if ($action == "getAvailableRoom"){
        getAvailableRooms($conn);
    }else if($action == "getRoom"){
        getRooms($conn);
    }else if ($action == "getRoomDetail"){
        if (array_key_exists("id",$_GET)){
            $roomId = $_GET["id"];
            getRoomDetail($conn,$_GET["id"],NULL);
        }else if (array_key_exists("bookingId",$_GET)){
            $bookingId = $_GET["bookingId"];
            getRoomDetail2($conn,$bookingId);
        }
    }else if($action == "search"){
        search($conn);

    }else if($action = "viewRoom"){
        viewRoom($conn,$_GET["bookingId"]);
    }else if($action = "getAllRooms"){

        getAllRooms($conn);
    }
    
}


function checkOut($conn)
{
    $id = $_POST["id"];
    $date = time() -600;
    $date = date("Y-m-d H:i:s", $date);
    $query = "UPDATE `hostel_booking` SET `end_date` = '" . $date . "' WHERE `hostel_booking`.`id` = $id;";
    echo ($query);
    $result = $conn->query($query);
}

function updateImg($conn)
{
    /*
     * Upload imgId
     */
    $id  = $_POST["id"];
    $target_dir = "../img/uploads/$id";
    $query = "";
        var_dump($query);
    if($_FILES["img_id"]!=NULL) {
        $target_file_id = $target_dir . "/img_id.jpg";
        $type = substr($_FILES["img_id"]["name"],-3,3);
        uploadImage($_FILES["img_id"]["tmp_name"],$target_file_id,$type);
        $img_id = substr($target_file_id,3);
        $query1 = "UPDATE `hostel_user` SET `img_id` = '$img_id' WHERE `hostel_user`.`id` = '$id';";
    }
    
    /*
     * Upload img_person
     */
    if($_FILES["img_person"]!=NULL) {
    
        $target_file_person = $target_dir . "/img_person.jpg";
        $type = substr($_FILES["img_person"]["name"], -3, 3);
        uploadImage($_FILES["img_person"]["tmp_name"], $target_file_person, $type);
        $img_person = substr($target_file_person,3);
        $query2 = "UPDATE `hostel_user` SET `img_person` = '$img_person' WHERE `hostel_user`.`id` = '$id';";
    }
    /*
     * Upload img_bike
     */
    if($_FILES["img_bike"]!=NULL) {
        $target_file_bike = $target_dir . "/img_bike.jpg";
        $type = substr($_FILES["img_bike"]["name"],-3,3);
        uploadImage($_FILES["img_bike"]["tmp_name"],$target_file_bike,$type);
        $img_bike = substr($target_file_bike,3);
        $query3 = "UPDATE `hostel_user` SET `img_bike` = '$img_bike' WHERE `hostel_user`.`id` = '$id';";
    }
    if ($_POST["type"] != NULL ){
        $type = $_POST["type"];
        $query4 = "UPDATE `hostel_user` SET `$type` = '' WHERE `hostel_user`.`id` = '$id';";
    }
    $conn->query($query1);
    $conn->query($query2);
    $conn->query($query3);
    $conn->query($query4);
        var_dump($conn);
    $conn->commit();
    return;
     
}

function updateDetail($conn)
{
    $column_name = $_POST["attr"];
    $value = $_POST["value"];
    $id  = $_POST["user_id"];
    
    
    if ($column_name == "start_date" || $column_name == "note" || $column_name == "locker"){
        $query4 = "UPDATE `hostel_booking` SET `$column_name` = '$value' WHERE `hostel_booking`.`user_id` = '$id';";    
    }else{
        $query4 = "UPDATE `hostel_user` SET `$column_name` = '$value' WHERE `hostel_user`.`id` = '$id';";    
    }
    
    
    $conn->query($query4);
    $conn->commit();
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

function changeRoom($conn)
{
    $new_room = $_POST["newRoom"];
    $old_room = $_POST["oldRoom"];
    $oldBookingID = $_POST["bookingID"];
    $new_id = 0;
    $query1 = "SELECT (MAX(id) + 1) as maxId from `hostel_booking`";
    $result = $conn->query($query1);
    while ($r = mysqli_fetch_assoc($result)) {
        $new_id = $r['maxId'];
    }
    $query4 = "UPDATE `hostel_booking` SET `room_id` = '$new_room', `id` = $new_id WHERE `hostel_booking`.`room_id` = '$old_room';";
    $conn->query($query4);
    $query2 = "UPDATE `hostel_addition` SET `booking_id` = $new_id WHERE `booking_id` =  $oldBookingID";
    $conn->query($query2);
    $conn->commit();
    return;
     
}


if (sizeof($_POST) > 0){
    $action = $_POST["action"];
    if($action=="check_out"){
        checkOut($conn);
    }else if($action=="updateDetail"){
        updateDetail($conn);
    }else if($action=="changeRoom"){
        changeRoom($conn);
    }else{
        updateImg($conn);
    }

}
