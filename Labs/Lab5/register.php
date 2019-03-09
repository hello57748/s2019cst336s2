<?php

    //return type (json object)
    header('Content-type: application/json');
    $jsonToReturn = array();
    
    //start session
    session_start();
    
    // Used to display an error message below the form
    $errorMessage = '';
    $username = '';
    $passwords = '';
    
    $isPostback = 'POST' === $_SERVER['REQUEST_METHOD'];
    
    if ($isPostback) {
        $errorMessage = processForm();
    }
    
    function processForm()
    {
        //we need to check username
        if ($_POST['process'] == "username_password_check") {
            global $username, $email, $passwords;
        
            //get username and passwords
            $username = (string)$_POST['username'];
            $passwords = $_POST['password'];
            $passwords[0] = (string)$passwords[0];
            $passwords[0] = (string)$passwords[0];
        
            // Validate the form
            $is_valid = true;
            
            //check if names are already used
            foreach ($_SESSION as $name => $value) {
                if ($name == $username) {
                    $is_valid = false;
                    $jsonToReturn["message"] = "Username already used";
                    
                }
            }
            
            //check if username is in password
            if ($is_valid) {
                if (strpos($passwords[0], $username) !== false) {
                    $is_valid = false;
                    $jsonToReturn["message"] = "username in password";
                }
            }
            
            // TODO: process the registration
            if ($is_valid) {
                $_SESSION[$username] = $passwords[0];
                $jsonToReturn["message"] = "success";
            }
            
            //return json array
            echo json_encode($jsonToReturn);
        }
        
        //we need to suggest password
        else if ($_POST['process'] == "password_suggestion") {
            
            //create random password
            $random_pass_8 = "";
            for ($i = 0; $i < 8; $i++) {
                $randomNum = rand(97, 122);
                $randomChar = chr($randomNum);
                $random_pass_8 = $random_pass_8 . (string)$randomChar;
            }
            
            //set random password
            $jsonToReturn["randomPassword"] = $random_pass_8;
            
            //return json array
            echo json_encode($jsonToReturn);
        }
    }
?>