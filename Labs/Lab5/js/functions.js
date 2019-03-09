$("document").ready( function() {
    
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
        
        //call ajax
        $.ajax({
            type: "POST",
            url: "register.php",
            dataType: "json",
            data: {
                "process": "username_password_check",
                "username": document.getElementById("usernameInput").value,
                "password": [document.getElementById("passwordInput").value, document.getElementById("passwordInputAgain").value],
            },
            success: function(data) {
                console.log(data);
                
                //valid username and everything filled out
                if (data["message"] === "success") {
                    
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
                else if (data["message"] === "Username already used") {
                    $("#usernameStatus").text("Username already taken").css("color", "red");
                }
                else if (data["message"] === "username in password") {
                    $("#passwordStatus").html("Username should not be in password").css("color", "red");
                }
            },
            error: function (error) {
                console.log(error);
            },
            complete: function(data, status) { //optional, used for debugging purposes
              //console.log(status);
            }
        });
        
    });
    
    //recommend password to user (fill in password field when clicked)
    $("#passwordInput").focusin(function autoGeneratePassword() {
        //call ajax
        $.ajax({
            type: "POST",
            url: "register.php",
            dataType: "json",
            data: {
                "process": "password_suggestion",
            },
            success: function(data) {
                
                //set passwords to recommended
                $("#passwordInput").val(data["randomPassword"]);
                $("#passwordInputAgain").val(data["randomPassword"]);
            },
            error: function (error) {
                console.log(error);
            },
        });
    });
    
});