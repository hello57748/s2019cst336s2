// 1. Get rid of file input button
// $("form button:nth-of-type(1)").click(function() {

$(document).ready(function() {
    //load in pics
    loadPicsFromDB();
});

function loadPicsFromDB() {
    $.ajax({
        type: "get",
        url: "api/downloadFile.php",
        dataType: "json",
        success: function(data, status) {
            console.log(data);
        },
        error: function(error) {
            console.log(error);
        },
    });
}

$("#selectButton").click(function() {
    console.log("clicked");
    $("form input[type='file']").trigger("click")
})

// 2. Use ajax to submit files
$("form input[type='file']").change(function(e) {
    $('#filesList').empty();
    $.map(this.files, function(val) {
        $('#filesList').append($('<div>').html(val.name));
    });
})

// 3. Send files with ajax
$('#uploadButton').click(function(e) {
    $.ajax({
        type: "post",
        url: "api/storeNameAndCaption.php",
        dataType: "json",
        data: {
            'name' : $('#nameInput').val(),
            'caption' : $('#captionInput').val(),
        },
        success: function(d, status) {
            console.log(d);
            setProgress(0);
            var formData = new FormData($('form')[0]);
            $.ajax({
                url: "api/uploadFile.php",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                mimeType: "multipart/form-data",
                cache: false,
                // This part gives up chunk progress of the file upload
                xhr: function() {
                    //upload Progress
                    var xhr = $.ajaxSettings.xhr();
                    if (xhr.upload) {
                        xhr.upload.addEventListener('progress', function(event) {
                            var percent = 0;
                            var position = event.loaded || event.position;
                            var total = event.total;
                            if (event.lengthComputable) {
                                percent = Math.ceil(position / total * 100);
                            }
                            //update progressbar
                            setProgress(percent);
                        }, true);
                    }
                    return xhr;
                }
            }).done(function(data, status, xhr) {
                console.log('upload done');
                //window.location.href = "<?php echo BASE_PATH?>/assets/<?php echo $controller->group ?>";
                console.log(xhr);
                $("#results").html(xhr.responseText)
            })
            .fail(function(xhr) {
                console.log('upload failed');
                console.log(xhr);
            })
            .always(function() {
                //console.log('done processing upload');
            });
        },
        error: function(error) {
            console.log(error);
        },
    });
});

function setProgress(percent) {
    $(".progress-bar").css("width", +percent + "%");
    $(".progress-bar").text(percent + "%");
}