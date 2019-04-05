$(document).ready(function() {
    
    i=1;
    var usersToDisplay;
    
    //call ajax
    $.ajax({
        type: "GET",
        url: "api/getUnmatchedUsers.php",
        dataType: "json",
        success: function(data, status) {
            console.log(data);
            usersToDisplay = data;
            
            //fill in first page
            $('#username').html('<b>About @' + usersToDisplay[i]['username'] + '<b>');
            $('#userPhoto').html('<img src="' + usersToDisplay[i]['picture_url'] + '"></img>');
            $('#aboutMe').html(usersToDisplay[i]['about_me']);
        },
        error: function (error) {
            console.log(error);
        },
    });
    
    $('#likeButton').on('click', function(){
        i++;
        //fill in first page
        $('#username').html('<b>About @' + usersToDisplay[i]['username'] + '<b>');
        $('#userPhoto').html('<img src="' + usersToDisplay[i]['picture_url'] + '"></img>');
        $('#aboutMe').html(usersToDisplay[i]['about_me']);
    });
    $('#dislikeButton').on('click', function(){
        i++;
        //fill in first page
        $('#username').html('<b>About @' + usersToDisplay[i]['username'] + '<b>');
        $('#userPhoto').html('<img src="' + usersToDisplay[i]['picture_url'] + '"></img>');
        $('#aboutMe').html(usersToDisplay[i]['about_me']);
    });
    $('#questionMarkButton').on('click', function(){
        i++;
        //fill in first page
        $('#username').html('<b>About @' + usersToDisplay[i]['username'] + '<b>');
        $('#userPhoto').html('<img src="' + usersToDisplay[i]['picture_url'] + '"></img>');
        $('#aboutMe').html(usersToDisplay[i]['about_me']);
    });
});