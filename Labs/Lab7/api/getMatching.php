<?php

//connect to database
include '../dbConnection.php';
$conn = getDatabaseConnection();

// $productId = $_GET['productId'];
$pName = $_GET['pName'];


$sql = 'SELECT * 
        FROM om_product 
        WHERE productName = :pName;';

$np = array();
$np['pName'] = $pName;

$stmt = $conn->prepare($sql);
$stmt->execute($np);
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($records);
?>