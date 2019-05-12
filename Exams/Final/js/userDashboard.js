//on load of page
//******************************************************************************
$(document).ready(function() {
    
    //fill link box with user's username
    $.ajax({
        type: "get",
        url: "api/getUsername.php",
        dataType: "json",
        success: function(data, status) {
            // console.log(data);
            //TO BE CHANGED
            $("#invitationlink").val("https://s2019cst336s2-hello57748.c9users.io/w/Exams/Final/bookSlot.php/?username=" + data["username"]);
        },
        error: function(error) {
            console.log(error);
            $('#error').html(error['responseText']);
        },
        complete: function(data, status) {
            //console.log(status);
        },
    });
            
    //fill up time slots
    addTimeSlotsToDatabase();
});
//******************************************************************************
    
//on click of logout button
//******************************************************************************
$("#logoutButton").on("click", function() {
    window.location = "api/logout.php";
});
//******************************************************************************
        
//copies link to clipboard when pressing invitation link button
//******************************************************************************
$("#copyInvitationLinkButton").on("click", function() {
    var copyText = document.getElementById("invitationlink");
    copyText.select();
    document.execCommand("copy");
});
//******************************************************************************
        
//returns difference in hours or minutes between mysql datetime objects
//******************************************************************************
function differenceInTime(start_time, end_time) {
    var start_hour = parseInt(start_time.substring(11, 13));
    var end_hour = parseInt(end_time.substring(11, 13));
    if (end_hour - start_hour > 0) {
        if (end_hour - start_hour == 1) {
            return (end_hour - start_hour) + " hour";
        }
        else {
            return (end_hour - start_hour) + " hours";
        }
    }
    else {
        var start_minute = parseInt(start_time.substring(14, 16));
        var end_minute = parseInt(end_time.substring(14, 16));
        return (end_minute - start_minute) + " min";
    }
}
//******************************************************************************

//add item to timeslot
//******************************************************************************
function addItemToTimeSlots() {
    //make ajax call to add a timeslot to the database
    $.ajax({
        type: "post",
        url: "api/addTimeSlot.php",
        dataType: "json",
        data: {
            "dateInput" : $("#dateInput").val(),
            "startTimeInput" : $("#startTimeInput").val(),
            "endTimeInput" : $("#endTimeInput").val(),
        },
        success: function(data, status) {
            // console.log(data);
            addTimeSlotsToDatabase();
            //clear inputs
            $("#dateInput").val("");
            $("#startTimeInput").val("");
            $("#endTimeInput").val("");
        },
        error: function(error) {
            console.log(error);
            $('#error').html(error['responseText']);
        },
        complete: function(data, status) {
            //console.log(status);
        },
    });
}
//******************************************************************************

//fills table with timeslots from database
//******************************************************************************
function addTimeSlotsToDatabase() {
    //clear table
    $("#timeslotTable").html("<tr><th>Date</th><th>Start Time</th><th>Duration</th><th>Booked By</th><th><button type='button' class='btn btn-info btn-lg' data-toggle='modal' data-target='#addTimeSlotModal'>Add Time Slot +</button></th></tr>");
    //fill in table with time slots
    $.ajax({
        type: "get",
        url: "api/getTimeslots.php",
        dataType: "json",
        success: function(data, status) {
            // console.log(data);
            
            // fill up timeslot table with data
            for (var i=0; i<data.length; i++) {
                var slot = data[i];
                
                var tableRowString = "<tr>";
                //date
                tableRowString += "<td>" + slot['date'] + "</td>";
                //start time
                tableRowString += "<td>" + slot['start_time'].substring(11) + "</td>";
                //duration
                tableRowString += "<td>" + differenceInTime(slot['start_time'], slot['end_time']) + "</td>";
                //status of booking
                tableRowString += "<td>" + "Not Booked" + "</td>";
                //buttons to see details and delete timeslot
                tableRowString += "<td>";
                tableRowString += "<button class='detailsButton'>Details</button>";
                //delete button
                tableRowString += "<button data-id='" + slot["id"] + "' type='button' class='deleteButton' data-toggle='modal' data-target='#deleteTimeSlotModal'>Delete</button>";
                //close out table row
                tableRowString += "</tr>";
                
                //set row
                $("#timeslotTable").append(tableRowString);
            }
        },
        error: function(error) {
            console.log(error);
            $('#error').html(error['responseText']);
        },
        complete: function(data, status) {
            //console.log(status);
        },
    });
}
//******************************************************************************

//when any delete button is pressed to get rid of a timeslot
//******************************************************************************
$(document).on('click', '.deleteButton', function() {
    // fill modal with info about time slot
    $.ajax({
        type: "get",
        url: "api/getTimeSlot.php",
        dataType: "json",
        data: {
            "id" : $(this).attr("data-id"),
        },
        success: function(data, status) {
            // console.log(data);
            //fill start and end times for time slot being deleted
            $("#startTimeDisplay").html(data[0]['start_time']);
            $("#endTimeDisplay").html(data[0]['end_time']);
            $("#timeSlotDeleteInfo").attr("data-id", data[0]['id']);
        },
        error: function(error) {
            console.log(error);
            $('#error').html(error['responseText']);
        },
        complete: function(data, status) {
            //console.log(status);
        },
    });
});
//******************************************************************************

//runs on click of "Yes, Remove It!" button
//******************************************************************************
$("#confirmTimeSlotDeletionButton").on("click", function() {
    //make call to api to get rid of time slot
    $.ajax({
        type: "post",
        url: "api/deleteTimeSlot.php",
        dataType: "json",
        data: {
            "id" : $("#timeSlotDeleteInfo").attr("data-id"),
        },
        success: function(data, status) {
            // console.log(data);
            //reload page after deletion
            addTimeSlotsToDatabase();
        },
        error: function(error) {
            console.log(error);
            $('#error').html(error['responseText']);
        },
        complete: function(data, status) {
            //console.log(status);
        },
    });
});
//******************************************************************************

