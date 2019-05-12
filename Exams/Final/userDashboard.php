<?php
    
    session_start();
    
    //check that a user is logged in
    if (!isset($_SESSION['username'])) {
        header("Location: login.html");
    }
?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8" />
        <title>Dashboard</title>
        <!--for bootstrap modal-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
        
        <!--CSS-->
        <style type="text/css">
            #logoutButton {
                margin-left: 90%;
                height: 40px;
                width: 80px;
            }
            #invitationBox {
                margin-top: 40px;
            }
            #invitationlink {
                width: 30%;
            }
            #timeslotTable {
                margin-top: 25px;
            }
            #addTimeSlotModal {
                display: hidden;
            }
            #rubricTable {
                border: 1px solid black;
                margin-top: 50px;
            }
        </style>
    </head>
    
    <body>
        
        <main>
            <!--logout button-->
            <div id="logoutBox">
                <button id="logoutButton">Logout</button>
            </div>
            
            <!--Invitation Link-->
            <div id="invitationBox">
                Invitation Link    
                <input id="invitationlink" type="text" readonly>
                <button id="copyInvitationLinkButton">copy link</button>
            </div>
            
            <!--table holding all time slots-->
            <table id="timeslotTable" style="width:100%">
            </table>
            
            <!-- Modal for adding timeslots -->
            <div class="modal fade" id="addTimeSlotModal" role="dialog">
                <div class="modal-dialog">
                
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Add Time Slot</h4>
                        </div>
                        <div class="modal-body">
                            <!--date input-->
                            <div>
                                Date: 
                                <input type="date" id="dateInput">
                            </div>
                            <!--start time input-->
                            <div>
                                Start Time:
                                <input type="time" id="startTimeInput">
                            </div>
                            <!--end time input-->
                            <div>
                                End Time:
                                <input type="time" id="endTimeInput">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button onclick="addItemToTimeSlots()" type="button" class="btn btn-default" data-dismiss="modal">Add</button>
                        </div>
                    </div>
                  
                </div>
            </div>
            
            <!-- Modal for deleting timeslots -->
            <div class="modal fade" id="deleteTimeSlotModal" role="dialog">
                <div class="modal-dialog">
                
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Delete Time Slot</h4>
                        </div>
                        <div class="modal-body">
                            <!--start time display-->
                            <div id="startTimeDisplay"></div>
                            <!--end time display-->
                            <div id="endTimeDisplay"></div>
                            <!--confirmation of delete message-->
                            <div>Are you sure you want to remove the time slot? This cannot be undone.</div>
                            <!--data-id for current time slot-->
                            <div id="timeSlotDeleteInfo" data-id=""></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button id="confirmTimeSlotDeletionButton" type="button" class="btn btn-default" data-dismiss="modal">Yes, Remove It!</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!--error text-->
            <div id="error"></div>
            
            <!--Rubric-->
            <div>
                <table id="rubricTable">
                    <thead>
                    <tr style="border: 1px solid black;">
                    <th style="text-align:left;border: 1px solid black;">#</th>
                    <th style="text-align:left;border: 1px solid black;">Task Description</th>
                    <th style="text-align:left;border: 1px solid black;">Points</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr style="border: 1px solid black;">
                    <td style="text-align:left;border: 1px solid black;">1</td>
                    <td style="text-align:left;border: 1px solid black; color: green;">You provide a ERD diagram representing the data and its relationships. This may be included in Cloud9 as a picture or from a designer tool</td>
                    <td style="text-align:left;border: 1px solid black;">10</td>
                    </tr>
                    <trstyle="border: 1px solid black;">
                    <td style="text-align:left;border: 1px solid black;">2</td>
                    <td style="text-align:left;border: 1px solid black;color: green;">Tables in MySQL match the ERD and support the requirements of the application</td>
                    <td style="text-align:left;border: 1px solid black;">20</td>
                    </tr>
                    <tr style="border: 1px solid black;">
                    <td style="text-align:left;border: 1px solid black;">3</td>
                    <td style="text-align:left;border: 1px solid black;color: green;">The list of available appointments is pulled from MySQL using the API endpoint and displayed using the specified page design</td>
                    <td style="text-align:left;border: 1px solid black;">20</td>
                    </tr>
                    <tr style="border: 1px solid black;">
                    <td style="text-align:left;border: 1px solid black;">4</td>
                    <td style="text-align:left;border: 1px solid black;color: green;">Available times with dates in the past do not show up in the Dashboard list</td>
                    <td style="text-align:left;border: 1px solid black;">5</td>
                    </tr>
                    <tr style="border: 1px solid black;">
                    <td style="text-align:left;border: 1px solid black;">5</td>
                    <td style="text-align:left;border: 1px solid black;color: green;">A user can add an available time slot to the MySQL using the API endpoint and displayed using the specified modal design</td>
                    <td style="text-align:left;border: 1px solid black;">20</td>
                    </tr>
                    <tr style="border: 1px solid black;">
                    <td style="text-align:left;border: 1px solid black;">6</td>
                    <td style="text-align:left;border: 1px solid black;color: green;">A user can remove an available time slot from MySQL using the API endpoint</td>
                    <td style="text-align:left;border: 1px solid black;">15</td>
                    </tr>
                    <tr style="border: 1px solid black;">
                    <td style="text-align:left;border: 1px solid black;">7</td>
                    <td style="text-align:left;border: 1px solid black;color: green;">The user confirms the removal using the specified modal design</td>
                    <td style="text-align:left;border: 1px solid black;">10</td>
                    </tr style="border: 1px solid black;">
                    <tr style="border: 1px solid black;">
                    <td style="text-align:left;border: 1px solid black;"></td>
                    <td style="text-align:left;border: 1px solid black;">TOTAL</td>
                    <td style="text-align:left;border: 1px solid black;">100</td>
                    </tr>
                    <tr style="border: 1px solid black;">
                    <td style="text-align:left;border: 1px solid black;"></td>
                    <td style="text-align:left;border: 1px solid black;color: green;">This rubric is properly included AND UPDATED (BONUS)</td>
                    <td style="text-align:left;border: 1px solid black;">2</td>
                    </tr>
                    <tr style="border: 1px solid black;">
                    <td style="text-align:left;border: 1px solid black;">BD</td>
                    <td style="text-align:left;border: 1px solid black;color: green;">Login works with a User table and BCrypt</td>
                    <td style="text-align:left;border: 1px solid black;">20</td>
                    </tr>
                    <tr style="border: 1px solid black;">
                    <td style="text-align:left;border: 1px solid black;">BD</td>
                    <td style="text-align:left;border: 1px solid black;color: red;">Add Google Signin for app login</td>
                    <td style="text-align:left;border: 1px solid black;">10</td>
                    </tr>
                    <tr style="border: 1px solid black;">
                    <td style="text-align:left;border: 1px solid black;">BD</td>
                    <td style="text-align:left;border: 1px solid black;color: green;">The app is deployed to Heroku</td>
                    <td style="text-align:left;border: 1px solid black;">15</td>
                    </tr>
                    <tr style="border: 1px solid black;">
                    <td style="text-align:left;border: 1px solid black;">BD</td>
                    <td style="text-align:left;border: 1px solid black;color: red;">A banner file can be uploaded and displayed</td>
                    <td style="text-align:left;border: 1px solid black;">20</td>
                    </tr>
                    <tr style="border: 1px solid black;">
                    <td style="text-align:left;border: 1px solid black;">BD</td>
                    <td style="text-align:left;border: 1px solid black;color: red;">The user can add multiple available time slots as specified</td>
                    <td style="text-align:left;border: 1px solid black;">10</td>
                    </tr>
                    <tr style="border: 1px solid black;">
                    <td style="text-align:left;border: 1px solid black;">BD</td>
                    <td style="text-align:left;border: 1px solid black;color: red;">In a separate page, you show the correct list of available time slots to the user who navigates to the correct invitation URL</td>
                    <td style="text-align:left;border: 1px solid black;">10</td>
                    </tr>
                    <tr style="border: 1px solid black;">
                    <td style="text-align:left;border: 1px solid black;">BD</td>
                    <td style="text-align:left;border: 1px solid black;color: red;">You correctly implement booking of the appointement, including all side effects</td>
                    <td style="text-align:left;border: 1px solid black;">30</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            
        </main>

    </body>


    <!--JAVASCRIPT-->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/userDashboard.js"></script>
</html>