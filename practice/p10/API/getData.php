<?php
    include 'DBConnection.php';
    session_start();
    $conn = getDBConnection();
    
    // TODO: Return all the rows from the datable table
    $sql = "SELECT name, email, major, zip FROM users ORDER BY name";;
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($records);
?>