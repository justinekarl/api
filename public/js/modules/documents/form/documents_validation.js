$( document ).ready( function () {


    /*$.validator.addMethod("file_required", function(value, element) {
        console.log(value);
        console.log(element);
        return this.optional(element);
    }, "Please Select a file");*/

   //


    $('#form_documents').submit(function(e) {

        if(document.getElementById("filename").files.length == 0 && $('#id').val() == ""){
            $('#file-required').text('Please Select a File');
            Ladda.stopAll();
            return false;
        }

        if(!$(this).valid()){
            Ladda.stopAll();
        }

    });

    $( "#form_documents" ).validate( {
        rules: {
            display_filename: {
                required : true
                //file_required : true
            },
            description: "required"
        },
        messages: {
            name: "Please enter Name for User Group"
        },
        errorElement: "em",
        errorPlacement: function ( error, element ) {
            // Add the `help-block` class to the error element
            error.addClass( "help-block" );
            // Add `has-feedback` class to the parent div.form-group
            // in order to add icons to inputs
            element.parents( ".col-sm-12" ).addClass( "has-feedback" );

            if ( element.prop( "type" ) === "checkbox" ) {
                error.insertAfter( element.parent( "label" ) );
            } else {
                error.insertAfter( element );
            }
            // Add the span element, if doesn't exists, and apply the icon classes to it.
            if ( !element.next( "span" )[ 0 ] ) {
                //$( "<span class='glyphicon glyphicon-remove form-control-feedback'></span>" ).insertAfter(" +" $(element ));
            }
        },
        success: function ( label, element ) {
            // Add the span element, if doesn't exists, and apply the icon classes to it.
            if ( !$( element ).next( "span" )[ 0 ] ) {
                //$( "<span class='glyphicon glyphicon-ok form-control-feedback'></span>" ).insertAfter( $( element ) );
            }
        },
        highlight: function ( element, errorClass, validClass ) {
            $( element ).parents( ".col-sm-12" ).addClass( "has-error" ).removeClass( "has-success" );
            $( element ).next( "span" ).addClass( "glyphicon-remove" ).removeClass( "glyphicon-ok" );
        },
        unhighlight: function ( element, errorClass, validClass ) {
            $( element ).parents( ".col-sm-12" ).addClass( "has-success" ).removeClass( "has-error" );
            $( element ).next( "span" ).addClass( "glyphicon-ok" ).removeClass( "glyphicon-remove" );
        }
    } );
} );


$.validator.setDefaults( {
    submitHandler: function () {
        if(document.getElementById("filename").files.length > 0 || $('#id').val() != ""){
            var formData = new FormData($("#form_documents")[0]);
            $('.level').each(function() {
                if($(this).is(':checked') && this.value == 2){
                    console.log('district');
                    formData.append("selected_option", JSON.stringify($('[name=selected_level_option_district]').val()));
                }else if($(this).is(':checked') && this.value == 3){
                    console.log('church');
                    formData.append("selected_option", JSON.stringify($('[name=selected_level_option_church]').val()));
                }
            });

            processDocuments(formData)

        }

    }
} );
