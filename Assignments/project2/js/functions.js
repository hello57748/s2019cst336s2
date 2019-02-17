$("document").ready( function() {
    //answers
    var q1Answer = "1994";
    var q2Answer = "1966";
    var q3Answer = "cancer";
    var q4Answer = "gold";
    var q5Answer = "Stevie Nicks";
    var q6Answer = "Barry Bonds";
                
    var correctAnswers = 0;
                
    //set all 
    $("button.submit").on("click", function(e) {
                    
        //disable button
        document.getElementById("submissionButton").disabled = true; 
                    
        var q1Attempt
        if(document.getElementById('q1_option_1').checked) q1Attempt = "1893";
        else if(document.getElementById('q1_option_2').checked) q1Attempt = "1967";
        else if(document.getElementById('q1_option_3').checked) q1Attempt = "1994";
        else if(document.getElementById('q1_option_4').checked) q1Attempt = "1996";
        else q1Attempt = "";
        var q2Attempt = document.getElementById("q2").value;
        var q3Attempt = "";
        if ( $('input[id="q3_option_1"]').is(':checked') ) q3Attempt += "cancer";
        if ( $('input[id="q3_option_2"]').is(':checked') ) q3Attempt += "diabetes";
        if ( $('input[id="q3_option_3"]').is(':checked') ) q3Attempt += "heart disease";
        var q4Attempt;
        var ddl = document.getElementById("disease_choices");
        q4Attempt = ddl.options[ddl.selectedIndex].value;
        var q5Attempt = document.getElementById("q5").value;
        var q6Attempt = document.getElementById("q6").value;
                    
        //check all answers
        if (q1Answer === q1Attempt) {
            correctAnswers++;
        	$("#q1Correct").css("visibility", "visible");
        }
        else $("#q1Incorrect").css("visibility", "visible");
                    
        if (q2Answer === q2Attempt) {
            correctAnswers++;
        	$("#q2Correct").css("visibility", "visible");
        }
        else $("#q2Incorrect").css("visibility", "visible");
                    
        if (q3Answer === q3Attempt) {
            correctAnswers++;
        	$("#q3Correct").css("visibility", "visible");
        }
        else $("#q3Incorrect").css("visibility", "visible");
                    
        if (q4Answer === q4Attempt) {
            correctAnswers++;
        	$("#q4Correct").css("visibility", "visible");
        }
        else $("#q4Incorrect").css("visibility", "visible");
                    
        if (q5Answer === q5Attempt) {
            correctAnswers++;
        	$("#q5Correct").css("visibility", "visible");
        }
        else $("#q5Incorrect").css("visibility", "visible");
                    
        if (q6Answer === q6Attempt) {
            correctAnswers++;
        	$("#q6Correct").css("visibility", "visible");
        }
        else $("#q6Incorrect").css("visibility", "visible");
                    
        //display results
        $("#results").html("Score: " + correctAnswers + " / 6");
        if (correctAnswers === 6) {
            $("#results").html($("#results").html() + " Congratulations!!! You scored over 90 percent!");
        }
                    
        //enable reset button and set onclick listener
        document.getElementById("resetButton").addEventListener("click", function(){
            //clear inputs
            document.getElementById("q1_option_1").checked = false;
            document.getElementById("q1_option_2").checked = false;
            document.getElementById("q1_option_3").checked = false;
            document.getElementById("q1_option_4").checked = false;
            $("#q3_option_1").prop('checked', false); 
            $("#q3_option_2").prop('checked', false); 
            $("#q3_option_3").prop('checked', false); 
            document.getElementById("q2").value = "";
            document.getElementById("disease_choices").value = "select a metal";
            document.getElementById("q5").value = "";
            document.getElementById("q6").value = "";
            //hide pictures
            $("#q1Correct").css("visibility", "hidden");
            $("#q2Correct").css("visibility", "hidden");
            $("#q3Correct").css("visibility", "hidden");
            $("#q4Correct").css("visibility", "hidden");
            $("#q5Correct").css("visibility", "hidden");
            $("#q6Correct").css("visibility", "hidden");
            $("#q1Incorrect").css("visibility", "hidden");
            $("#q2Incorrect").css("visibility", "hidden");
            $("#q3Incorrect").css("visibility", "hidden");
            $("#q4Incorrect").css("visibility", "hidden");
            $("#q5Incorrect").css("visibility", "hidden");
            $("#q6Incorrect").css("visibility", "hidden");
            document.getElementById("resetButton").disabled = true;
            document.getElementById("submissionButton").disabled = false; 
            //clear results
            $("#results").html("");
            correctAnswers = 0;
        });
        document.getElementById("resetButton").disabled = false;
    });
});