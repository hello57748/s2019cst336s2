//global search term
var searchKey = "";

//when like button is clicked
function likePicture(i) {
    // console.log($('#buttonNum'+i).attr('liked'));
    // console.log($('#picNum'+i).attr('src'));
    
    // if liked set to 1, add url to database
    if ( $('#buttonNum'+i).attr('liked') === '0' ) {
        $('#buttonNum'+i).attr('liked', '1');
        $('#buttonNum'+i).html("<img width='25px' src='https://simple.showdeolabs.com/csumb/scd/classes/336/assignments/labs/8/assets/favorite-on.png'>");
        $.ajax({
            type: "POST",
            url: "api/picAddDelete.php",
            dataType: "json",
            data: {
                'searchKey' : searchKey,
                'operation' : 'insert',
                'url' : $('#picNum'+i).attr('src'),
            },
            success: function(data, status) {
                // console.log(data);
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
    }
    // if liked set to 0, remove url from database
    else {
        $('#buttonNum'+i).attr('liked', '0');
        $('#buttonNum'+i).html("<img width='25px' src='https://simple.showdeolabs.com/csumb/scd/classes/336/assignments/labs/8/assets/favorite.png'>");
        $.ajax({
            type: "POST",
            url: "api/picAddDelete.php",
            dataType: "json",
            data: {
                'searchKey' : searchKey,
                'operation' : 'delete',
                'url' : $('#picNum'+i).attr('src'),
            },
            success: function(data, status) {
                // console.log(data);
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
    }
}

//onclick of search button
function search() {
    //get search terms
    searchKey = $('#searchBar').val();
    
    // load in photos
    $.ajax({
        type: "GET",
        url: "api/curlPicGetter.php",
        dataType: "json",
        data: {
            'searchKey' : searchKey,
        },
        success: function(data, status) {
            //clear old search
            $('#allPhotos').html("");
            
            //display pics
            
            for (var i = 0; i < 9 && i <  data['hits'].length; i) {
                var str = "<tr>";
                for (var j = 0; j < 3 && i <  data['hits'].length; j++, i++) {
                    str += "<td><img id='picNum" + i +"' src='" + data['hits'][i]['largeImageURL'] +"' width=250px></img>";
                    str += "<button liked=0 id='buttonNum" + i +"' onClick='likePicture(" + i  + ")'> <img width=25px src='https://simple.showdeolabs.com/csumb/scd/classes/336/assignments/labs/8/assets/favorite.png' width=250px></img></button></td>";
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
}