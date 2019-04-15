<?php
    include 'DBConnection.php';
    session_start();
    $conn = getDBConnection();
    
    $_SESSION["progress"] = 0;
    
    // TODO: Grab all of our paramters from the session
    $parameters[":name"]= $_SESSION["name"];
    $parameters[":email"]= $_SESSION["email"];
    $parameters[":major"]= $_SESSION["major"];
    $parameters[":zip"]= $_SESSION["zip"];
    
    // TODO: Execute SQL to add a row to database table
    $sql = "INSERT INTO users 
            (name, major, email, zip) 
            VALUES (:name, :major, :email, :zip)";
            
    $stmt = $conn->prepare($sql);
    $stmt->execute($parameters);
    
    // Destory the session once you submit
    session_destroy();
?>
