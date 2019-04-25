<?php

    $msg = '';
    //when user presses upload button
    if (isset($_POST['upload'])) {
        
        //where to store uploaded image
        $target = '../img/' . $_FILES['image']['name'];
        
        //connect to db
        include 'dbConn.php';
        $conn = getDatabaseConnection();
        
        //get all data from form
        $np = array();
        $np[':image'] = $_FILES['image']['name'];
        $np[':name'] = $_POST['name'];
        $np[':caption'] = $_POST['caption'];
        
        //sql statement to upload all this stuff
        $sql = "INSERT INTO images
                (image, name, caption)
                VALUES
                (:image, :name, :caption)";
                
        //run sql
        $stmt = $conn->prepare($sql);
        $stmt->execute($np);
        
        //move uploaded folder into img folder
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            echo "Image uploaded successfully";
        }
        else {
            echo "There was a problem uploading image";
        }
        
        header("Location: ../index.php");
    }
?>