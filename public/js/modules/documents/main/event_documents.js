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

