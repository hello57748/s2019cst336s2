
//on load
$(document).ready(function() {
    //load in photos
    $.ajax({
        type: "GET",
        url: "api/getKeywords.php",
        dataType: "json",
        success: function(data, status) {
            // console.log(data);
                    
            //clear old keys
            $('#keywords').html("");
            var str = "";
            for (var i = 0; i < data.length; i++) str += "<button class='keywordResultButton' value='" + data[i]['searchKey'] + "'>" + data[i]['searchKey'] + "</button><br>";
            //display keywords
            $('#keywords').html(str);
        },
        error: function (error) {
            console.log(error);
            $('#error').html("");
            $('#error').html(error['responseText']);
        },
        complete: function() {
            //console.log(arguments);
        },
    });
});

//click button to reveal search results
$(document).on('click', '.keywordResultButton', function() {
    var key = $(this).val();

    // load in photos
    $.ajax({
        type: "GET",
        url: "api/getLikedPics.php",
        dataType: "json",
        data: {
            'searchKey' : key,
        },
        success: function(data, status) {
            // console.log(data);
            
            //clear old search
            $('#allPhotos').html("");
            
            //display pics
            
            for (var i = 0; i <  data.length; i) {
                var str = "<tr>";
                for (var j = 0; j < 3 && i <  data.length; j++, i++) {
                    str += "<td><img id='picNum" + i +"' src='" + data[i]['src'] +"' width=250px></img></td>";
                    // str += "<button liked=0 id='buttonNum" + i +"' onClick='likePicture(" + i  + ")'> <img width=25px src='https://simple.showdeolabs.com/csumb/scd/classes/336/assignments/labs/8/assets/favorite.png' width=250px></img></button></td>";
                }
                str += "</tr>";
                $('#allPhotos').append(str);
            };
                    
        },
        error: function (error) {
            console.log(error);
            console.log(error['responseText']);
            $('#error').html("");
            $('#error').html(error['responseText']);
        },
        complete: function() {
            //console.log(arguments);
        },
    });
});
