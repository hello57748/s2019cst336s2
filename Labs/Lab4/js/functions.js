$("document").ready( function() {
    //input is put in to zipcode box
    $('#zipCodeInput').on('input', function() {
          
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
        
        // check that both passwords are filled out
        if (document.getElementById("passwordInput").value === "" || document.getElementById("passwordInputAgain").value === "") {
            console.log("please fill out both password boxes");
        }
        // check that passwords match
        else if ( document.getElementById("passwordInput").value === document.getElementById("passwordInputAgain").value ) {
            console.log("match");
        }
        else {
            console.log("no match");
        }
    });
});