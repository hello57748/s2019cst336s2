<?php

function getDatabaseConnection($dbname = 'cinder') {
    $host = 'localhost'; //cloud 9 acting as host
    $username = 'hello57748';
    $password = '';

    //creates db connection
    $dbConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    //displays errors when accessing tables
    $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    return $dbConn;
}
?>