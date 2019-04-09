// JavaScript File

$(document).ready(function() {
    
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
    
    $("#logoutButton").on("click", function() {
        window.location = "dashboard/logout.php";
    });
    
    //on click of the search button
    $('#searchForm').on('click', function() {
        getSearchResults();
    });
    
    //displaying purchase history modal
    $(document).on('click', '.historyLink', function() {
        $.ajax({
            type: "GET",
            url: "api/getPurchaseHistory.php",
            dataType: "json",
            data: {
                'productId' : $(this).attr('data-id'),
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
                $('#purchaseHistoryModal').modal("show");
            },
            error: function (error) {
                console.log(error);
            },
        });
    });
    
    //displaying product info modal
    $(document).on('click', '.productInfoLink', function() {
        $.ajax({
            type: "GET",
            url: "api/getProductInfo.php",
            dataType: "json",
            data: {
                'productId' : $(this).attr('data-id'),
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
                $('#productInfoModal').modal("show");
            },
            error: function (error) {
                console.log(error);
            },
        });
    });
    
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
                    //history button
                    var resultsString = "<tr><td><button class='historyLink' data-id='" + key['productId'] + "'>History</button></td>";
                    //product info button
                    resultsString += "<td><a href='#' class='productInfoLink' data-id='" + key['productId'] + "'>" + '<b>' + key['productName'] + "</a></td></tr>";
                    $('#results').append(resultsString);
                });
            },
            error: function (error) {
                console.log(error);
            },
        });
    }
});