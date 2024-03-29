<?php
  session_start();

  $httpMethod = strtoupper($_SERVER['REQUEST_METHOD']);

  switch($httpMethod) {
    case "OPTIONS":
      onOptions();
      exit();
    case "GET":
      onGet();
      break;
    case 'POST':
      onPost()
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

  function onOptions() {
    // Allows anyone to hit your API, not just this c9 domain
    header("Access-Control-Allow-Headers: X-ACCESS_TOKEN, Access-Control-Allow-Origin, Authorization, Origin, X-Requested-With, Content-Type, Content-Range, Content-Disposition, Content-Description");
    header("Access-Control-Allow-Methods: POST, GET");
    header("Access-Control-Max-Age: 3600");
  }

  function onGet() {
    // Allow any client to access
    header("Access-Control-Allow-Origin: *");
    // Let the client know the format of the data being returned
    header("Content-Type: application/json");

    // // TODO: do stuff to get the $results which is an associative array
    // $results = array();
    // array_push($results, "something");
    
    // get data from MySQL
    $dbConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = " SELECT * FROM table_name WHERE id = :id ";
    $stmt = $dbConn->prepare($sql);
    $stmt->execute(array(':id' => '1'));
    
    // while ($row = $stmt->fetch()) {
    //     echo $row['field1_name'] . ", " . $row['field2_name'];
    // }
    
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Sending back down as JSON
    echo json_encode($results);
  }

  function onPost() {
    // Get the body json that was sent
    $rawJsonString = file_get_contents("php://input");

    //var_dump($rawJsonString);

    // Make it a associative array (true, second param)
    $jsonData = json_decode($rawJsonString, true);

    // TODO: do stuff to get the $results which is an associative array
    $results = array();

    // Allow any client to access
    header("Access-Control-Allow-Origin: *");
    // Let the client know the format of the data being returned
    header("Content-Type: application/json");

    // Sending back down as JSON
    echo json_encode($results);
  }
?>