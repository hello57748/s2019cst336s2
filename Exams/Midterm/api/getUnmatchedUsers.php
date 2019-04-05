<?php

//connect to database
include '../dbConnection.php';
$conn = getDatabaseConnection();

$sql = 'SELECT * FROM user WHERE 1';

$stmt = $conn->prepare($sql);
$stmt->execute();
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($records);
?>