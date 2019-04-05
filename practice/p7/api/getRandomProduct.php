<?php

include '../dbConnection.php';

$conn = getDatabaseConnection();

$sql = "SELECT productName, productPrice FROM mp_product ORDER BY RAND() LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->execute();
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($records);
?>

