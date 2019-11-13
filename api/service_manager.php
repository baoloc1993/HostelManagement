<?php
/**
 * Created by PhpStorm.
 * User: Luis Ngo
 * Date: 1/10/2017
 * Time: 8:37 PM
 */
require_once ("config.php");
// Create connection
$conn = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD,MYSQL_DATABASE);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
function getServices($conn,$bookingId)
{
    $query = "SELECT `hostel_addition`.id,price, date,name FROM `hostel_addition` INNER JOIN `hostel_service_type`
        WHERE `hostel_addition`.`type` = `hostel_service_type`.id AND `hostel_addition`.`booking_id`=$bookingId";
//    var_dump($query);
    $result = $conn->query($query);
    $rows = array();
    while ($r = mysqli_fetch_assoc($result)) {
        $rows[] = $r;
    }
    print json_encode ($rows);
}
function getServices2($conn,$id,$start,$end)
{

    $query = "SELECT `hostel_addition`.id,price, `date`,name,`booking_id` FROM `hostel_addition` INNER JOIN `hostel_service_type`
        WHERE `hostel_addition`.`type` = `hostel_service_type`.id";
    $where = " ";
    if ($id > 0) $where .= " AND `hostel_service_type`.`id` = $id";
    if ($start != null ) $where .= " AND `hostel_addition`.`date` >= '$start'";
    if ($end != null ) $where .= "AND  `hostel_addition`.`date` <= DATE('$end') + INTERVAL 1 DAY";
    $query .= $where;
    $result = $conn->query($query);
    $rows = array();
    while ($r = mysqli_fetch_assoc($result)) {
        $rows[] = $r;
    }
    print json_encode ($rows);
}
function getListService($conn)
{
    $query = "SELECT * FROM `hostel_service_type`";
    $result = $conn->query($query);
    $rows = array();
    while ($r = mysqli_fetch_assoc($result)) {
        $rows[] = $r;
    }
    print json_encode ($rows );
}
function addService($conn)
{
    $service = $_POST["service"];
    $price = $_POST["price"];
    $bookingId = $_POST["booking_id"];
    $query = "INSERT INTO `hostel_addition` ( `booking_id`, `type`, `price`, `date`) VALUES ('$bookingId', '$service', '$price', CURRENT_TIMESTAMP)";
    $result = $conn->query($query);
}
function removeService($conn)
{
    $id = $_POST["id"];
    $query = "DELETE FROM `hostel_addition` WHERE `hostel_addition`.`id`= $id";

    $result = $conn->query($query);
}

if (sizeof($_GET) > 0) {
    $action = $_GET["action"];
    if ($action == "getServices") {
        if (array_key_exists("bookingId", $_GET)) {
            $bookingId = $_GET["bookingId"];
            getServices($conn, $bookingId);
        } else {
            $id = $_GET["id"];
            if (array_key_exists("startDate", $_GET)) $start = $_GET["startDate"];
            else $start = null;
            if (array_key_exists("endDate", $_GET)) $end = $_GET["endDate"];
            else $end = null;
            getServices2($conn,$id,$start,$end);
        }
    } else if ($action == "getListService") {
        getListService($conn);
    }
}
if (sizeof($_POST) > 0){
    $action = $_POST["action"];
    if ($action == "add_service"){
        addService($conn);
    }else if($action=="remove_service") {
        removeService($conn);
    }
}
