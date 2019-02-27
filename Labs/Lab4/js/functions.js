$("document").ready( function() {
    
    //create liist of taken usernames
    var takenUsernames = ['ljp503', 'hello5728', 'pete9684'];
    
    //check if username is valid
    $('#usernameInput').on('input', function() {
        //reset status
        $("usernameStatus").html("");
        
        var taken = false;
        for (var i = 0; i < takenUsernames.length; i++) {
            if (document.getElementById("usernameInput").value === takenUsernames[i] ) {
                taken = true;
            }
        }
        
        // if name matches on others
        if (document.getElementById("usernameInput").value === "") {
            //get rid of error message
            $("#usernameStatus").html("");
        }
        else if (taken == true) {
            $("#usernameStatus").text("Username already taken").css("color", "red");
        }
        else {
            $("#usernameStatus").text("Username valid").css("color", "green");
        }
    });
    
    //input is put in to zipcode box
    $('#zipCodeInput').on('input', function() {
        
        if (document.getElementById("zipCodeInput").value === "") {
            $("#zipCodeStatus").html("");
        }
          
        //call ajax
        $.ajax({
            type: "GET",
            // zip=93955
            url: "http://itcdland.csumb.edu/~milara/ajax/cityInfoByZip.php?",
            dataType: "json",
            data: {
            "zip": document.getElementById("zipCodeInput").value,
            },
            success: function(data) {
                  
                //setback
                $("#city").html("City: ");
                $("#latitude").html("Latitude: ");
                $("#longitude").html("Longitude: ");
                  
                if (!data.city) {
                    $("#zipCodeStatus").html("  Zip code not found");
                }
                else {
                    $("#zipCodeStatus").html("");
                    //change city, long, and lat
                    $("#city").html("City: " + data.city);
                    $("#latitude").html("Latitude: " + data.latitude);
                    $("#longitude").html("Longitude: " + data.longitude);
                }
                  
                // $(".weather__heading").html(`${data.name}, ${data.sys.country}`)
                // $(".weather__feed img").attr("src", `http://openweathermap.org/img/w/${data.weather[0].icon}.png`);
            },
            complete: function(data, status) { //optional, used for debugging purposes
                //console.log(status);
            }
        });
    });
        
    //input is put in to state box
    $('#stateInput').on('input', function() {
          
        //clear selector because state may be invalid
        $("#countySelect").empty();
          
        //call ajax
        $.ajax({
            type: "GET",
            // zip=93955
            url: "http://itcdland.csumb.edu/~milara/ajax/countyList.php?",
            dataType: "json",
            data: {
              "state": document.getElementById("stateInput").value,
            },
            success: function(data) {
              
              //add counties to selector if data is valid
              if (data) {
                for (var i in data) {
                  $("#countySelect").append('<option value=1>' + data[i].county + '</option>');
                }
              }
              
            },
            complete: function(data, status) { //optional, used for debugging purposes
              //console.log(status);
            }
        });
    });
        
    //submission button is clicked
    $('#submissionButton').on('click', function() {
        
        //is this submission valid?
        var validSubmission = true;
        
        // check that both passwords are filled out
        if (document.getElementById("passwordInput").value === "" && document.getElementById("passwordInputAgain").value === "") {
            $("#passwordStatus").html("Please fill out both password boxes").css("color", "red");
            validSubmission = false;
        }
        // check that passwords match
        else if ( document.getElementById("passwordInput").value === document.getElementById("passwordInputAgain").value ) {
            //valid
            $("#passwordStatus").html("");
        }
        else {
            $("#passwordStatus").html("Retype Password").css("color", "red");
            validSubmission = false;
        }
        
        //add username to list of usernames
        if ($("#usernameStatus").text() === "Username already taken") {
            validSubmission = false;
        }
        
        //stuff not filled out
        if ($("#firstNameInput").val() == "" || $("#lastNameInput").val() == "" || $("#emailInput").val() == "" || $("#phoneInput").val() == "" || $("#zipCodeInput").val() == "" || $("#stateInput").val() == "") {
            validSubmission = false;
        }
        
        if (validSubmission) {
            
            //add username
            takenUsernames.push($("#usernameInput").val());
            
            //clear everything
            $("#firstNameInput").val("");
            $("#lastNameInput").val("");
            $("#emailInput").val("");
            $("#phoneInput").val("");
            $("#zipCodeInput").val("");
            $("#city").html("City:");
            $("#longitude").html("Latitude:");
            $("#latitude").html("Longitude:");
            $("#stateInput").val("");
            $("#countySelect").html("");
            $("#usernameInput").val("");
            $("#usernameStatus").html("");
            $("#passwordInput").val("");
            $("#passwordInputAgain").val("");
            $("#passwordStatus").html("");
            
        }
        
    });
});