<?php

//connect to database
include 'DBConnection.php';
$conn = getDatabaseConnection();

//check if we need to add or remove
$np = array();
$np[':src'] = $_POST['url'];
$np[':key'] = $_POST['searchKey'];
$operation = $_POST['operation'];
$sql = '';

if ($operation == 'insert') {
    $sql = 'INSERT INTO liked_images
            (src, searchKey) 
            VALUES (:src, :key);';
}
else if ($operation == 'delete') {
    $sql = 'DELETE FROM liked_images
            WHERE (src = :src AND searchKey = :key);';
}

$stmt = $conn->prepare($sql);
$stmt->execute($np);
$records['operation'] = $operation;
echo json_encode($records);

?>