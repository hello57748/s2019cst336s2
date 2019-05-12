<?php

//connect to database
include 'DBConnection.php';
$conn = getDBConn();

//get session so that user_id can be aquired
session_start();

$sql = "SELECT id FROM s_user
        WHERE username = :username;";

//get user's id to add time slot later on
$stmt = $conn->prepare($sql);
$stmt->execute(array(":username" => $_SESSION["username"]));
$records = $stmt->fetch();
// echo json_encode($records);

$np = array();
$np[":date"] = $_POST["dateInput"];
$np[":start_time"] = strval($_POST["dateInput"]) . " " . strval($_POST["startTimeInput"]) . ":00";
$np[":end_time"] = strval($_POST["dateInput"]) . " " . strval($_POST["endTimeInput"]) . ":00";
$np[":id"] = $records["id"];

$sql = "INSERT INTO s_timeslot (date, start_time, end_time, s_user_id) 
        VALUES (:date, :start_time, :end_time, :id);";
        
$stmt = $conn->prepare($sql);
$stmt->execute($np);

// $np["sql"] = $sql;
echo json_encode($np);
?>