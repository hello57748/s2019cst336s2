<?php
    session_start();

    if (!isset($_SESSION['username'])){
      header("Location: dashboard/login.html");
    }
?>

<!DOCTYPE html>
<html>
    
    <head>
        <meta charset='utf-8'/>
        <title> OtterMart Product Search </title>
        <link rel="stylesheet" href="css/styles.css" type="text/css"/>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </head>
    
    <body>
        <div>
            
            <!--logout button and title-->
            <div id="logoutBox">
                <h1> OtterMart Product Search </h1>
                <button id="logoutButton" class="btn btn-danger">Logout</button>
            </div>
            
            <h1> Role: Customer </h1>
            
            <form>
                Product: <input type="text" name="product"/>
                <br>
                
                Category:
                    <select name="category">
                        <option value=''> Select One </option>
                    </select>
                <br>
                
                Price: From <input type="text" name="priceFrom" size='7' />
                       To <input type="text" name="priceTo" size='7' />
                <br>
                
                Order result by:
                <br>
                
                <input type="radio" name="orderBy" value="price"/> Price <br>
                <input type="radio" name="orderBy" value="name"/> Name
                
                <br><br>
            </form>
            
            <br>
            <button id="searchForm"> Search </button>
            <hr>
            <div id='results'></div>
            
            <!--modal to display purchase history info-->
            <div id="purchaseHistoryModal" class="modal" tabindex='-1' role='dialog'>
                <div class='modal-dialog' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title'>Product History</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        <div class='modal-body'>
                            <div id="history"></div>
                        </div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!--modal to display product info-->
            <div id="productInfoModal" class="modal" tabindex='-1' role='dialog'>
                <div class='modal-dialog' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title'>Product Info</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        <div class='modal-body'>
                            <div id="productInfoMain"></div>
                        </div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </body>
    
    <!--js-->
    <script type="text/javascript" src="js/indexUser.js"></script>
</html>