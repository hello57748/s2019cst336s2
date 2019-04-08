<?php
//Used to check the letter the user inputed in the form, and if the letter is in the word
//Should return an array of booleans as the api
include '../dbConnection.php';
$conn = getDatabaseConnection("hangman");

$np['wordId'] = $_GET['wordId'];

$sql = "SELECT word FROM words WHERE word_id = :wordId";

$stmt = $conn -> prepare($sql);  
$stmt->execute($np);
$record = $stmt->fetch(PDO::FETCH_ASSOC);

$indecies = array();
if (sizeof($record)) {
    $letter = $_GET['letter'];
    $word = $record['word'];
    for ($i=0; $i<strlen($word); $i++) {
        if ($word[$i] == $letter) array_push($indecies, $i);
    }
}

// $record = array();
$record['letter'] = $_GET['letter'];
$indecies = json_encode($indecies);
$record['indecies'] = $indecies;
echo json_encode($record);
?>