<?php
  session_start();

  $httpMethod = strtoupper($_SERVER['REQUEST_METHOD']);

  switch($httpMethod) {
    case "OPTIONS":
      // Allows anyone to hit your API, not just this c9 domain
      header("Access-Control-Allow-Headers: X-ACCESS_TOKEN, Access-Control-Allow-Origin, Authorization, Origin, X-Requested-With, Content-Type, Content-Range, Content-Disposition, Content-Description");
      header("Access-Control-Allow-Methods: POST, GET");
      header("Access-Control-Max-Age: 3600");
      exit();
    case "GET":
      // TODO: Access-Control-Allow-Origin
      http_response_code(401);
      echo "Not Supported";
      break;
    case 'POST':
      // Allow any client to access
      header("Access-Control-Allow-Origin: *");
      // Let the client know the format of the data being returned
      header("Content-Type: application/json");

      // Get the body json that was sent
      $rawJsonString = file_get_contents("php://input");

      // Make it a associative array (true, second param)
      $jsonData = json_decode($rawJsonString, true);

      // Perform password validations

      // Was a password provided?
      if (empty($_POST["password"])) {
        echo json_encode(array(
          "isSignedUp" => false,
          "message" => "No password provided"));

        exit;
      }

      if (empty($_POST["confirmation"])) {
        echo json_encode(array(
          "isSignedUp" => false,
          "message" => "No password confirmation provided"));

        exit;
      }

      if ($_POST["password"] != $_POST["confirmation"]) {
        echo json_encode(array(
          "isSignedUp" => false,
          "message" => "password does not equal confirmation"));

        exit;
      }

      // Hash my password!!!!!!
      $options = [
        'cost' => 11,
      ];

      $hashedPassword = password_hash($_POST['password'], PASSWORD_BCRYPT, $options);

      try {

        // TODO: do stuff to get the $results which is an associative array
        $dbname = 'heroku_d727c510ebe6dad';
        $host = 'us-cdbr-iron-east-03.cleardb.net';
        $username = 'b8282773fb41e0';
        $password = 'a78ad875';

        // Get Data from DB
        $dbConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO s_user (username, password) " .
               "VALUES (:username, :hashedPassword);";

        $stmt = $dbConn->prepare($sql);
        $stmt->execute(array (
          ":username" => $_POST['username'],
          ":hashedPassword" => $hashedPassword));

        $_SESSION["username"] = $_POST['username'];

        // Sending back down as JSON
        echo json_encode(array("isSignedUp" => true));

      } catch (PDOException $ex) {
        switch ($ex->getCode()) {
          case "23000":
            echo json_encode(array(
              "isSignedUp" => false,
              "message"=> "username taken, try another",
              "details" => $ex->getMessage()));
            break;
          default:
            echo json_encode(array(
              "isSignedUp" => false,
              "message"=> $ex->getMessage(),
              "details" => $ex->getMessage()));
            break;
        }
        exit;
      }
      break;
    case 'PUT':
      // TODO: Access-Control-Allow-Origin
      http_response_code(401);
      echo "Not Supported";
      break;
    case 'DELETE':
      // TODO: Access-Control-Allow-Origin
      http_response_code(401);
      break;
  }
?>
