<?php

//connect to database
include 'DBConnection.php';
$conn = getDBConn();

//start session to get username
session_start();

$np = array();
$np[":username"] = $_SESSION["username"];

$sql = "SELECT s_timeslot.id, s_timeslot.date, s_timeslot.start_time, s_timeslot.end_time, s_timeslot.s_user_id 
        FROM s_timeslot
        INNER JOIN s_user 
        ON s_timeslot.s_user_id = s_user.id
        WHERE s_user.username = :username
        AND s_timeslot.date >= NOW()
        ORDER BY s_timeslot.start_time;";

$stmt = $conn->prepare($sql);
$stmt->execute($np);
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($records);
?>