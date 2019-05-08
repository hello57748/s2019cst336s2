<?php
    include 'DBConnection.php';
    session_start();
    //TODO: Save incoming data into session
    
    if(!isset($_SESSION["progress"])){
        $_SESSION["progress"] = 0;
    }
    
    if ($_POST["name"] && $_POST["email"]) {
        $_SESSION["name"] = $_POST["name"];
        $_SESSION["email"] = $_POST["email"];
        $_SESSION["progress"] = 1;
    }
    if ($_SESSION["name"] && $_SESSION["email"] && $_POST["major"] && $_POST["zip"]) {
        $_SESSION["major"] = $_POST["major"];
        $_SESSION["zip"] = $_POST["zip"];
        $_SESSION["progress"] = 2;
    }
    
    echo json_encode($_SESSION);
?>