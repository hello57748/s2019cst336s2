<?php

//connect to database
include '../dbConnection.php';
$conn = getDatabaseConnection();

//get data from database based on search box text
$namedParameters = array();
$sql = 'SELECT * FROM om_product WHERE 1';

//checks if input product text box is empty
if (!empty($_GET['product'])) {
    //add sql for both statements
    $sql .= ' AND (productName LIKE :productName OR productDescription LIKE :productDescription)';
    
    //looks through product name
    $namedParameters[':productName'] = '%' . $_GET['product'] . '%';
    
    //searches productDescription
    $namedParameters[':productDescription'] = '%' . $_GET['product'] . '%';
}

//checks if category is selected
if (!empty($_GET['category'])) {
    $sql .= " AND catId = :categoryId";
    $namedParameters[':categoryId'] = $_GET['category'];
}

//checking validity of price input
if (!empty($_GET['priceFrom'])) {
    $sql .= " AND price >= :priceFrom";
    $namedParameters[':priceFrom'] = $_GET['priceFrom'];
}
if (!empty($_GET['priceTo'])) {
    $sql .= " AND price <= :priceTo";
    $namedParameters[':priceTo'] = $_GET['priceTo'];
}

//checks if radio button is selected
if (isset($_GET['orderBy'])) {
    if ($_GET['orderBy'] == 'price') {
        $sql .= ' ORDER BY price';
    }
    else if ($_GET['orderBy'] == 'name') {
        $sql .= ' ORDER BY productName';
    }
}

//run sql and return json
$stmt = $conn->prepare($sql);
$stmt->execute($namedParameters);
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($records);
?>