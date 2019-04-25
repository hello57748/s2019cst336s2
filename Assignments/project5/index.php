<!DOCTYPE html>
<html>
    <head>
        <title>Project 5: Event Media Dump</title>
        <link href="css/index.css" rel="stylesheet" type="text/css" />
    </head>
    
    <body>
        <div id="content">
            <h1>Upload Images Here</h1>
            <form method="post" action="api/uploadImage.php" enctype="multipart/form-data">
                <input type="hidden" name="size" value="1000000"/>
                <div>
                    <input type="file" name="image"/>
                </div>
                <div>
                    <input type="text" name="name" placeholder="Enter your name..."/>
                </div>
                <div>
                    <textarea name="caption" cols="40" placeholder="Enter a caption for this image..."></textarea>
                </div>
                <div>
                    <input type="submit" name="upload" value="Upload Image"/>
                </div>
            </form>
        </div>
        
        <!--display all photos from db-->
        <div>
            <?php
                //connect to db
                include 'api/dbConn.php';
                $conn = getDatabaseConnection();
            
                $sql = "SELECT * FROM images";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
                // echo json_encode($records);
                
                //fill page with images
                
                echo "<h1>Uploaded Images</h1><br>";
                foreach ($records as $key => $value) {
                    echo "<a target='_blank' href='img/" . $value['image'] . "'>
                            <img src='img/" . $value['image'] . "' alt=''>
                          </a><br>";
                    echo "<p1>Uploaded By: " . $value['name'] . "</p1><br>";
                    echo "<p1>Upload Time: " . $value['upload_time'] . "</p1><br>";
                    echo "<p1>Caption: " . $value['caption'] . "</p1><br><br><br><br><br><br>";
                }
            ?>
        </div>
    </body>
</html>