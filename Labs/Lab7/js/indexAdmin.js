// JavaScript File

$(document).ready(function() {
    
    //wait on add item button to be clicked and display modal when it is
    $('#addItemButton').on('click', function() {
        $('#addProductName').val("");
        $('#addProductImageURL').val("");
        $('#addProductDescription').val("");
        $('#addProductPrice').val("");
        $('#addProductCategory').val("");
        $('#addItemModal').modal("show");
    });
    $('#addConfirmButton').on('click', function() {
        //call function that adds valid items to database
        addItemToDB();
    });
    
    $("#logoutButton").on("click", function() {
        window.location = "dashboard/logout.php";
    });
    
    //call ajax
    $.ajax({
        type: "GET",
        url: "api/getCategories.php",
        dataType: "json",
        success: function(data, status) {
            data.forEach(function(key) {
                $("[name=category]").append("<option value=" + key["catId"] + ">" + key["catName"] + "</option>");
            });
        },
        error: function (error) {
            console.log(error);
        },
    });
    
    //on click of the search button
    $('#searchForm').on('click', function() {
        getSearchResults();
    });
    
    //displaying purchase history modal
    $(document).on('click', '.historyLink', function() {
        $('#purchaseHistoryModal').modal("show");
        $.ajax({
            type: "GET",
            url: "api/getPurchaseHistory.php",
            dataType: "json",
            data: {
                'productId' : $(this).attr('id'),
            },
            success: function(data, status) {
                if (data.length != 0) {
                    $("#history").html("");
                    $("#history").append(data[0]['productName'] + "<br />");
                    $("#history").append("<img src='" + data[0]['productImage'] + "' width='200' /> <br />");
                    data.forEach(function(key) {
                        $('#history').append('Purchase Date: ' + key['purchaseDate'] + '<br/>');
                        $('#history').append('Unit Price: ' + key['unitPrice'] + '<br/>');
                        $('#history').append('Quantity : ' + key['quantity'] + '<br/>');
                    });
                }
                else {
                    $("#history").html('No purchase history for this item.');
                }
            },
            error: function (error) {
                console.log(error);
            },
        });
    });
    
    //displaying product info modal
    $(document).on('click', '.productInfoLink', function() {
        $('#productInfoModal').modal("show");
        $.ajax({
            type: "GET",
            url: "api/getProductInfo.php",
            dataType: "json",
            data: {
                'productId' : $(this).attr('id'),
            },
            success: function(data, status) {
                if (data.length != 0) {
                    $("#productInfoMain").html("");
                    $("#productInfoMain").append(data[0]['productName'] + "<br />");
                    $("#productInfoMain").append("<img src='" + data[0]['productImage'] + "' width='200' /> <br />");
                    $('#productInfoMain').append('Product Description: ' + data[0]['productDescription'] + '<br/>');
                    $('#productInfoMain').append('Price: ' + data[0]['price'] + '<br/>');
                }
                else {
                    $("#productInfoMain").html('No product info for this item.');
                }
            },
            error: function (error) {
                console.log(error);
            },
        });
    });
    
    function addItemToDB() {
        //get values from text input boxes
        var newProductName = $('#addProductName').val();
        var newProductDescription = $('#addProductDescription').val();
        var newProductImageURL = $('#addProductImageURL').val();
        var newProductPrice = $('#addProductPrice').val();
        var newProductCategory = $('#addProductCategory').val();
        //convert price to float
        newProductPrice = parseFloat(newProductPrice);
        
        //make sure all inputs are valid and not empty
        if (newProductName === "" || newProductDescription === "" || newProductImageURL === "" || newProductPrice.isNaN  || newProductCategory === "") return;
        $.ajax({
            type: "GET",
            url: "api/getMatching.php",
            dataType: "json",
            data: {
                'pName' : newProductName,
            },
            success: function(data, status) {
                if (data.length > 0) return;
                // console.log(data);
            },
            error: function (error) {
                console.log(error);
            },
        });
        
        //item is unique and valid, so add it to db
        $.ajax({
            type: "POST",
            url: "api/addProductToDB.php",
            dataType: "json",
            data: {
                'pName' : newProductName,
                'pDescription' : newProductDescription,
                'pImageURL' : newProductImageURL,
                'pPrice' : newProductPrice,
                'pCategory' : newProductCategory,
            },
            success: function(data, status) {
                // console.log(data);
            },
            error: function (error) {
                // console.log(error);
            },
        });
        
        
    }
    
    //product editing modal
    //on click of the product edit button
    $(document).on('click', '.editProductButton', function() {
        $('#productEditModal').modal("show");
        $.ajax({
            type: "GET",
            url: "api/getProductInfo.php",
            dataType: "json",
            data: {
                'productId' : $(this).attr('id'),
            },
            success: function(data, status) {
                $("#editProductName").val(data[0]['productName']);
                $("#editProductDescription").val(data[0]['productDescription']);
                $("#editProductImageURL").val(data[0]['productImage']);
                $("#editProductPrice").val(data[0]['price']);
                $("#editProductCategory").val(data[0]['catId']);
            },
            error: function (error) {
                console.log(error);
            },
        });
        
        //on confirmation of edit
        var pId = $(this).attr('id');
        $('#editConfirmButton').on('click', function() {
            //call function that adds valid items to database
            editItemInDB(pId);
            getSearchResults();
        });
    });
    
    //edit item with new info
    function editItemInDB(productId) {
        //get values from text input boxes
        var newProductName = $('#editProductName').val();
        var newProductDescription = $('#editProductDescription').val();
        var newProductImageURL = $('#editProductImageURL').val();
        var newProductPrice = $('#editProductPrice').val();
        var newProductCategory = $('#editProductCategory').val();
        //convert price to float
        newProductPrice = parseFloat(newProductPrice);
        
        //item is valid, so edit it in db
        $.ajax({
            type: "POST",
            url: "api/editProduct.php",
            dataType: "json",
            data: {
                'pId' : productId,
                'pName' : newProductName,
                'pDescription' : newProductDescription,
                'pImageURL' : newProductImageURL,
                'pPrice' : newProductPrice,
                'pCategory' : newProductCategory,
            },
            success: function(data, status) {
                console.log(data);
            },
            error: function (error) {
                // console.log(error);
            },
        });
    }
    
    function getSearchResults() {
        $.ajax({
            type: "GET",
            url: "api/getSearchResults.php",
            dataType: "json",
            data: {
                'product' : $('[name=product]').val(),
                'category' : $('[name=category]').val(),
                'priceFrom' : $('[name=priceFrom]').val(),
                'priceTo' : $('[name=priceTo]').val(),
                'orderBy' : $('[name=orderBy]:checked').val(),
            },
            success: function(data, status) {
                $('#results').html('<h3> Products Found: </h3>');
                data.forEach(function(key) {
                    //delete button
                    $("#results").append("<button class='deleteProductButton' id='" + key['productId'] + "'>" + 'Delete Item' + "</button> ");
                    $("#results").append("<a href='#' class='historyLink' id='" + key['productId'] + "'>History</a> ");
                    // $('#results').append(key['productName'] + " " + key['productDescription'] + " $" + key['price'] + '<br>');
                    $("#results").append("<a href='#' class='productInfoLink' id='" + key['productId'] + "'>" + '<b>' + key['productName'] + '<b>' + "</a> ");
                    //edit button
                    $("#results").append("<button class='editProductButton' id='" + key['productId'] + "'>" + 'Edit Item' + "</button> " + '<br>');
                });
            },
            error: function (error) {
            },
        });
    }
    
    //delete an item from the database
    $(document).on('click', '.deleteProductButton', function() {
        $.ajax({
            type: "GET",
            url: "api/getProductInfo.php",
            dataType: "json",
            data: {
                'productId' : $(this).attr('id'),
            },
            success: function(data, status) {
                $("#deleteProductName").val(data[0]['productName']);
                $("#deleteProductDescription").val(data[0]['productDescription']);
                $("#deleteProductImageURL").val(data[0]['productImage']);
                $("#deleteProductPrice").val(data[0]['price']);
                $("#deleteProductCategory").val(data[0]['catId']);
            },
            error: function (error) {
            },
        });
        
        $('#productDeleteModal').modal("show");
        
        //on confirmation of delete
        var pId = $(this).attr('id');
        $('#deleteConfirmButton').on('click', function() {
            //call function that deletes items from database
            $.ajax({
                type: "POST",
                url: "api/deleteProduct.php",
                dataType: "json",
                data: {
                    'pId' : pId,
                },
                success: function(data, status) {
                },
                error: function (error) {
                },
            });
            getSearchResults();
        });
    });
});