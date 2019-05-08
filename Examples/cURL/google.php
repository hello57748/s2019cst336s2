<?php
    // //step1
    // $cSession = curl_init();
    
    // //step2
    // curl_setopt($cSession,CURLOPT_URL,"http://www.google.com/search?q=curl");
    // curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
    // curl_setopt($cSession,CURLOPT_HEADER, false);
    
    // //step3
    // $results = curl_exec($cSession);
    // $err = curl_error($cSession);
    
    // //step4
    // curl_close($cSession);
    
    // //step5
    // echo $results;

    /*
    Here is what my command would look like on the command line
    curl    -X "GET" "https://api.spotify.com/v1/browse/featured-playlists"
            -H "Accept: application/json"
            -H "Content-Type: application/json"
            -H "Authorization: Bearer BQCgRt4mIiK4IfGGJ2ZLOpwKXINh-XTy8VylqGsC35mdQZPfjTBbcs2Nk1QQRyeSuhpwLHgL86vVj5WA5mZmRmlB7xODcwzfl2T-9Hv-Ctl5-jGxrn_x0Wo9R7svRTo498GMmgDy-cMzZoZS__DpKtXDfDXPkc-ZC6uKAIkc8fExyhp53MTXO0TVQztzTUFxP5TEUwULwXKt7RzX6Kv40ip_91kSaVvjB7DSDDas3uPQ"
    */
    
    // Set the API key for my test account
    $apiKey = "BQCgRt4mIiK4IfGGJ2ZLOpwKXINh-XTy8VylqGsC35mdQZPfjTBbcs2Nk1QQRyeSuhpwLHgL86vVj5WA5mZmRmlB7xODcwzfl2T-9Hv-Ctl5-jGxrn_x0Wo9R7svRTo498GMmgDy-cMzZoZS__DpKtXDfDXPkc-ZC6uKAIkc8fExyhp53MTXO0TVQztzTUFxP5TEUwULwXKt7RzX6Kv40ip_91kSaVvjB7DSDDas3uPQ";
    
    // Setup the CURL session
    $cSession = curl_init();
    
    // Setup the CURL options
    curl_setopt($cSession,CURLOPT_URL,"https://api.spotify.com/v1/browse/featured-playlists");
    curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($cSession,CURLOPT_HEADER, false);
    
    // Add headers to the HTTP command
    curl_setopt($cSession,CURLOPT_HTTPHEADER, array(
        "Accept: application/json",
        "Content-Type: application/json",
        "Authorization: Bearer $apiKey"
    ));
    
    // Execute the CURL command
    $results = curl_exec($cSession);
    
    // Check for specific non-zero error numbers
    $errno = curl_errno($cSession);
    if ($errno) {
        switch ($errno) {
            default:
                echo "Error #$errno...execution halted";
                break;
        }
    
        // Close the session and exit
        curl_close($cSession);
        exit();
    }
    
    // Close the session
    curl_close($cSession);
    
    // HintL: it is sometimes helpful to take echo the
    // $results out and copy the array, then paste it into
    // a beautifier online to see the data. For example, you
    // could put the string JSON $results into the site
    // https://codebeautify.org/jsonviewer
    
    // Convert the results to an associative array
    $musicData = json_decode($results);
    
    
    // Let's just get one of the items and echo the JSON for that only.
    echo json_encode($musicData->playlists->items[0]);

?>