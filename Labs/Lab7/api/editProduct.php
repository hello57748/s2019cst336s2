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
$np['pId'] = $_POST['pId'];

$sql = 'UPDATE om_product 
        SET productName = :pName, productDescription = :pDescription, productImage = :pImageURL, price = :pPrice, catId = :pCategory
        WHERE productId = :pId';

$stmt = $conn->prepare($sql);
$stmt->execute($np);
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($records);
?>