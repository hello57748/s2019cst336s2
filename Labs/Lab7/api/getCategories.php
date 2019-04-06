<?php

include '../dbConnection.php';

$conn = getDatabaseConnection();

//sql to get categories from the database
$sql = "SELECT catId, catName FROM om_category ORDER BY catName";

$stmt = $conn->prepare($sql);
$stmt->execute();
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($records);
?>