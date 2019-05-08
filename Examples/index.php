<!DOCTYPE html>

<html>
    <head>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <script src="https://code.jquery.com/jquery-3.1.0.js"></script>
        
    </head>
    <body>
        <div class="jumbotron">
            <h1>Sign up for the Otter Newsletter</h1>
        </div>
        <div class = "main">
        <div class="panel panel-default">
            <div class="panel-heading"> Please enter your information</div>
            <div class="panel-body content" id ="form">
                
                <div id ="page0" class="allForm">
                    <form class= "form">
                    <input name="progress" type="hidden" value=1 />
                    Enter your name: <input type="text" name="name"/>
                    Enter your email: <input type="text" name="email"/>
                    <input class="button" type="submit" value="next" />
                    </form>
                </div>
                
                <div id="page1" class="allForm">
                    <form class = "form">
                    <input name="progress" type="hidden" value=2 />
                    Enter your major: <input type="text" name="major"/>
                    Enter your zip: <input type="text" name="zip"/>
                    <input class="button" type="submit" value="next" />
                  </form>
                </div>
                
                <div id="page2" class="allForm">
                    Submit this data?<br>
                    <button class="button" id="send" onClick="send()">
                        Submit
                    </button>
                  </form>
                </div>
        </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"> Current data</div>
            <div class="panel-body content" id="current" >
                 <!-- Session data will go here -->
            </div>
            </div>
        </div>
        <button id="view" onClick="viewData()"> View Data?</button>
        
    </body>
    
    <script type='text/javascript'>
    
    //Function to call API to save data into Session
    function displayNextForm(element){
        
        var array;
        if (element!=null){
            array = element.serialize();
        } 
        else {
            array = {};
        }
        
        $.ajax({
            type: "post",
            url: "API/saveData.php",
            dataType: "json",
            data: array,
            success: function(data){
               console.log(data);
                var htmlString="";
                for (var key in data){
                    htmlString+= key+": "+ data[key]+"<br>";
                }
                $("#current").html(htmlString);
                
                $(".allForm").hide();
                $('#view').hide();
                $("#page"+data["progress"]).show();
            },
            error: function (error) {
                console.log(error);
            },
            complete: function(data, status) {
                console.log(status);
            },
        });
        
    }
    function send() {
        console.log("submit pressed");
        $.ajax({
            type: "post",
            url: "API/sendData.php",
            dataType: "json",
            success: function(data){
                console.log(data);
                var element = null;
                displayNextForm(element);
            },
            error: function (error) {
                console.log(error);
            },
            complete: function(data, status) {
                console.log(status);
            },
        });
    }
    function viewData() {
        $.ajax({
            type: "post",
            url: "API/getData.php",
            dataType: "json",
            success: function(data){
                console.log(data);
                var htmlString = "";
                for (var key in data){
                    htmlString+= "name: " + key['name'] + "<br>";
                    htmlString+= "email: " + key['email'] + "<br>";
                    htmlString+= "major: " + key['major'] + "<br>";
                    htmlString+= "zip: " + key['zip'] + "<br><br>";
                }
                $('#view').html(htmlString);
            },
            error: function (error) {
                console.log(error);
            },
            complete: function(data, status) {
                console.log(status);
            },
        });
    }
    
    $(document).ready(function(){
        //Call it as soon as page loads
        displayNextForm(null);
        $('.form').submit (function (event) {
            event.preventDefault();
            var element = $(this);
            displayNextForm(element);
        });
        
    });
    </script>
</html>