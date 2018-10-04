var bodyTag = $("body");

bodyTag.on("click", ".user-approve", function(event){
    var student_id = $(this).data("student_id");
    var teacher_id = $(this).data("teacher_id");
    var status = 1;
    var formData = {};
    formData.student_id = student_id;
    formData.teacher_id = teacher_id;
    formData.status = status;

    sNotify("warning",
        "Approve Student",
        "Are you sure you want to approve this student?",
        "Yes!",
        approveStudent,
        formData,
        true);
});


bodyTag.on("click", ".user-decline", function(event){
    var student_id = $(this).data("student_id");
    var teacher_id = $(this).data("teacher_id");
    var status = 0;
    var formData = {};
    formData.student_id = student_id;
    formData.teacher_id = teacher_id;
    formData.status = status;
    sNotify("warning",
        "Decline Student",
        "Are you sure you want to decline this student?",
        "Yes!",
        approveStudent,
        formData,
        true);
});


bodyTag.on("click", ".company-user-approve", function(event){
    var student_id = $(this).data("student_id");
    var teacher_id = $(this).data("teacher_id");
    var status = 1;
    var formData = {};
    formData.student_id = student_id;
    formData.teacher_id = teacher_id;
    formData.status = status;
    sNotify("warning",
        "Decline Student",
        "Are you sure you want to decline this student?",
        "Yes!",
        approveStudent,
        formData,
        true);
});

bodyTag.on("click", ".company-user-decline", function(event){
    var student_id = $(this).data("student_id");
    var teacher_id = $(this).data("teacher_id");
    var status = 1;
    var formData = {};
    formData.student_id = student_id;
    formData.teacher_id = teacher_id;
    formData.status = status;
    sNotify("warning",
        "Decline Student",
        "Are you sure you want to decline this student?",
        "Yes!",
        approveStudent,
        formData,
        true);
});

