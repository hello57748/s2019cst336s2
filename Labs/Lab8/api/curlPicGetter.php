<?php

// Allow any client to access
header("Access-Control-Allow-Origin: *");
// Let the client know the format of the data being returned
header("Content-Type: application/json");

//step1
$cSession = curl_init();

//step2
$key = $_GET['searchKey'];
curl_setopt($cSession,CURLOPT_URL,"https://pixabay.com/api/?key=12231316-4d149315996386d7b7f963584&q=" . $key . "&image_type=photo&orientation=horizontal&safesearch=true&per_page=9");
curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
curl_setopt($cSession,CURLOPT_HEADER, false);

//step3
$results = curl_exec($cSession);
$err = curl_error($cSession);

//step4
curl_close($cSession);

//step5
echo $results;

?>