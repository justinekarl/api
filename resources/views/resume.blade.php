@extends('layout')
@section('css')
    <link rel="stylesheet" href="{{$templatePlugin->rootLocation()}}/css/ladda/ladda-themeless.min.css">
    <link rel="stylesheet" href="{{$templatePlugin->rootLocation()}}/js/sweetalert2/dist/sweetalert2.min.css">
    <style>
        .content {
            position: absolute;
            top: 50%;
            left:50%;
            transform: translate(-50%,-50%);
        }
    </style>

@endsection

@section('javascript')

    <script src="{{$templatePlugin->rootLocation()}}/js/jsvalidation/jquery.validate.js"></script>

    <script src="{{$templatePlugin->rootLocation()}}/js/ladda/spin.min.js"></script>
    <script src="{{$templatePlugin->rootLocation()}}/js/ladda/ladda.min.js"></script>
    <script src="{{$templatePlugin->rootLocation()}}/js/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="{{$templatePlugin->rootLocation()}}/js/notify/snotify.js"></script>


    <script src="{{$templatePlugin->rootLocation()}}/js/modules/documents/main/documents.js"></script>
    <script src="{{$templatePlugin->rootLocation()}}/js/modules/documents/main/event_documents.js"></script>
    <script src="{{$templatePlugin->rootLocation()}}/js/modules/documents/form/documents_validation.js"></script>
@endsection

@section('content')
    <div class="content container-fluid text-center pagination-centered">


        <form method="POST" id="form_documents" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="hidden" id = "student_id" name = "student_id" value="{{@ $student_id != null ? $student_id : ''}}">
            <div class="row">
                <div class="col-md-12">

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="filename">Select a file</label>
                                <div class="input-group">
                                    <label class="input-group-btn">
                                                        <span class="btn btn-primary">
                                                            Browse&hellip; <input type="file" style="display: none;" name="filename" id="filename" required>
                                                        </span>
                                    </label>
                                    <input type="text" class="form-control" readonly>
                                </div>
                                <div id="file-required" class="strong bg-danger">

                                </div>
                                <span class="help-block">
                                                        Accepted formats: pdf, doc, docx
                                                </span>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4 col-md-offset-8 text-right">
                                <button type="submit" class="btn btn-success btn-ladda-progress ladda-button" data-style="expand-right">Submit <span class="glyphicon glyphicon-ok"></span>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
@endsection
