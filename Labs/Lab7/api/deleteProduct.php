<?php

//connect to database
include '../dbConnection.php';
$conn = getDatabaseConnection();

$np = array();
$np['pId'] = $_POST['pId'];

$sql = 'DELETE FROM om_product
        WHERE productId = :pId';

$stmt = $conn->prepare($sql);
$stmt->execute($np);

echo json_encode($records);
?>