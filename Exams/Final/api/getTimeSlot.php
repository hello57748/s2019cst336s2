<?php

//connect to database
include 'DBConnection.php';
$conn = getDBConn();

$np = array();
$np[":id"] = $_GET["id"];

$sql = "SELECT * FROM s_timeslot
        WHERE id = :id;";

$stmt = $conn->prepare($sql);
$stmt->execute($np);
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($records);
?>