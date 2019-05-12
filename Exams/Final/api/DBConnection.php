<?php
// database config text
// mysql://b5f872661c80e1:4cb4913a@us-cdbr-iron-east-02.cleardb.net/heroku_2f5d071b652d3b7?reconnect=true
function getDBConn() {
    $dbname = 'heroku_d727c510ebe6dad';
    $host = 'us-cdbr-iron-east-03.cleardb.net';
    $username = 'b8282773fb41e0';
    $password = 'a78ad875';

    if  (strpos($_SERVER['HTTP_HOST'], 'herokuapp') !== false) {
        $url = parse_url(getenv("CLEARDB_DATABASE_URL"));
        $host = $url["host"];
        $dbname = substr($url["path"], 1);
        $username = $url["user"];
        $password = $url["pass"];
    }

    //creates db connection
    $dbConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    //displays errors when accessing tables
    $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $dbConn;
}
?>