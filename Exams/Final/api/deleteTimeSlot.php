<?php

//connect to database
include 'DBConnection.php';
$conn = getDBConn();

$np = array();
$np[":id"] = $_POST["id"];

$sql = "DELETE FROM s_timeslot
        WHERE id = :id;";

$stmt = $conn->prepare($sql);
$stmt->execute($np);

echo json_encode($np);
?>