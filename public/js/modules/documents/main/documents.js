var currentLocation = currentLocation || location.protocol + '//' + location.host + '/';
var mainRoute = 'documents';

var processDocuments = function(formData){
    $.ajax({
        type: 'POST',
        data: formData,
        url: currentLocation + 'ojtmonitoring/upload',
        'dataType': 'json',
        cache: false,
        contentType: false,
        processData: false,
        success: function(data){
            Ladda.stopAll();
            if(data.response === false){
                sNotify("error", "Upload", data.message);
            }else if(data.response === true){
                loadDocuments();
            }
        }
    });
};

var loadDocuments = function(){
    window.location = currentLocation + 'ojtmonitoring/upload/ok';
};

var deleteDocuments = function(formData){
    $.ajax({
        type: 'POST',
        data: formData,
        url: currentLocation + mainRoute + '/delete',
        'dataType': 'json',
        success: function(data){
            Ladda.stopAll();
            if(data.response === false){
                sNotify("error", "Documents", data.message);
            }else if(data.response === true){
                sNotify("success", "Documents", data.message,"Ok",function(){
                    loadDocuments();
                },[],true);
            }
        }
    });
};

var approveStudent = function(formData){
    $.ajax({
        type: 'POST',
        data: formData,
        url: currentLocation + 'ojtmonitoring/approve',
        'dataType': 'json',
        success: function(data){
            Ladda.stopAll();
            if(data.response === false){
                sNotify("error", "Approve", data.message);
            }else if(data.response === true){
                sNotify("success", "Successful", data.message,"Ok",function(){
                    location.reload();
                },[],true);


            }
        }
    });
};


$(function (){
    Ladda.bind(".btn-ladda-progress", {
        callback: function(instance) {
            var progress = 0;
            var interval = setInterval(function() {
                progress = Math.min(progress + Math.random() * 0.1, 0.8);
                instance.setProgress(progress);
            }, 200);
        }
    });


    //for file upload
    $(document).on('change', ':file', function() {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);

        if(document.getElementById("filename").files.length > 0){
            $('#file-required').text('');
        }
    });

    $(document).ready( function() {
        $(':file').on('fileselect', function(event, numFiles, label) {

            var input = $(this).parents('.input-group').find(':text'),
                log = numFiles > 1 ? numFiles + ' files selected' : label;

            if( input.length ) {
                input.val(log);
            } else {
                // if( log ) alert(log);
            }

        });
    });
    //for file upload
});
