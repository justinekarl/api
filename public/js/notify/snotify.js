var sNotify = function(type, title, text, confirmButtonText, execFunction, formData, hasCallBk){

    var params = {};
    var args = formData;

    if(typeof hasCallBk === 'undefined'){
        hasCallBk = false;
    }

    params.title = title;
    params.text = text;


    switch(type){
        case "success":
            params.type = "success";
            params.confirmButtonColor = "#66BB6A";
            break;
        case "error":
            params.type = "error";
            params.confirmButtonColor = "#EF5350";
            break;
        case "warning":
            params.type = "warning";
            params.confirmButtonColor = "#FF7043";
            break;
        default:
            console.log("invalid type");
            break;
    }

    if(hasCallBk === false){
        swal(params);
    }else{
        if(type === "warning"){
            params.confirmButtonText = confirmButtonText;
            params.showLoaderOnConfirm = true;
            params.showCancelButton = true;
            swal(params).then(result => {
                if (result.value){
                    execFunction.call(this, args);
                }
            });
        }else{
            swal(params).then(function() {
                execFunction.call(this, args);
            });
        }
    }


}
