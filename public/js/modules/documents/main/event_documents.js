var bodyTag = $("body");

bodyTag.on("click", ".documents-delete", function(event){
    var id = $(this).data("id");
    var formData = {};
    formData.id = id;
    sNotify("warning",
        "Delete Document",
        "Are you sure you want to delete this Document?",
        "Yes Delete It!",
        deleteDocuments,
        formData,
        true);
});



$('.level').on('ifChecked', function(event) {
    if(event.target.value == 2){
        $('#districts_options').show();
        $('#churches_options').hide();
        $('.select2').select2();
    }else if(event.target.value == 3){
        $('#churches_options').show();
        $('#districts_options').hide();
        $('.select2').select2();
    }else{
        $('#districts_options').hide();
        $('#churches_options').hide();
    }
});