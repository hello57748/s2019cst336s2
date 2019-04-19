<?php

//connect to database
include 'DBConnection.php';
$conn = getDatabaseConnection();

// Allow any client to access
header("Access-Control-Allow-Origin: *");
// Let the client know the format of the data being returned
header("Content-Type: application/json");

$sql = 'SELECT DISTINCT searchKey 
        FROM liked_images
        ORDER BY searchKey;';
        
$stmt = $conn->prepare($sql);
$stmt->execute();
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($records);

?>