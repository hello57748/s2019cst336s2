<?php

//connect to database
include 'DBConnection.php';
$conn = getDBConn();

//start session to get username
session_start();
$records['username'] = $_SESSION['username'];
// $np = array();
// $np[":username"] = $_SESSION["username"];

// $sql = "SELECT id FROM s_user
//         WHERE username = :username;";

// $stmt = $conn->prepare($sql);
// $stmt->execute($np);
// $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($records);
?>