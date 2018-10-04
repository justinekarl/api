var bodyTag = $("body");

bodyTag.on("click", ".user-approve", function(event){
    var id = $(this).data("id");
    var formData = {};
    formData.id = id;
    sNotify("warning",
        "Approve Student",
        "Are you sure you want to approve this student?",
        "Yes!",
        approveStudent,
        formData,
        true);
});

