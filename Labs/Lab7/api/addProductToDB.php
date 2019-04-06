<?php

//connect to database
include '../dbConnection.php';
$conn = getDatabaseConnection();

$np = array();
$np['pName'] = $_POST['pName'];
$np['pDescription'] = $_POST['pDescription'];
$np['pImageURL'] = $_POST['pImageURL'];
$np['pPrice'] = $_POST['pPrice'];
$np['pCategory'] = $_POST['pCategory'];

$sql = 'INSERT INTO om_product 
(productName, productDescription, productImage, price, catId) 
VALUES (:pName, :pDescription, :pImageURL, :pPrice, :pCategory);';

$stmt = $conn->prepare($sql);
$stmt->execute($np);
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($records);
?>