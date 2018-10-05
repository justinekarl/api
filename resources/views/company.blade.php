@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{$templatePlugin->rootLocation()}}/provider/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="{{$templatePlugin->rootLocation()}}/css/ladda/ladda-themeless.min.css">
    <link rel="stylesheet" href="{{$templatePlugin->rootLocation()}}/js/sweetalert2/dist/sweetalert2.min.css">
@endsection

@section('javascript')
    <script src="{{$templatePlugin->rootLocation()}}/provider/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{$templatePlugin->rootLocation()}}/provider/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

    <script src="{{$templatePlugin->rootLocation()}}/js/ladda/spin.min.js"></script>
    <script src="{{$templatePlugin->rootLocation()}}/js/ladda/ladda.min.js"></script>
    <script src="{{$templatePlugin->rootLocation()}}/js/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="{{$templatePlugin->rootLocation()}}/js/notify/snotify.js"></script>


    <script src="{{$templatePlugin->rootLocation()}}/js/modules/documents/main/documents.js"></script>
    <script src="{{$templatePlugin->rootLocation()}}/js/modules/documents/main/event_documents.js"></script>

@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="container-fluid">
                    <div class="panel panel-flat">
                        <div class="panel-body">
                            {{--<div class="panel-heading">
                                <div class="row">
                                    <div class="col-lg-10 col-md-10 col-sm-10">
                                        <section class="content-header">
                                            <h1>
                                                <i class="fa fa-file-pdf-o"></i> Documents
                                            </h1>
                                        </section>
                                    </div>
                                </div>

                            </div>--}}

                            <div class="content">
                                <div class="panel-body">
                                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" >
                                        <thead>
                                        <tr>
                                            <th class="text-center" > Student </th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($students as $student)

                                                <tr>
                                                    <td>
                                                        <div class="row text-center">
                                                            Student Name : {{$student->student_name}}
                                                        </div>

                                                        <div class="row text-center">
                                                            College : {{$student->college}}
                                                        </div>

                                                        <div class="row text-center">
                                                            Course : {{$student->course}}
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="btn-group">
                                                            <a href="#" class="btn btn-primary btn-sm company-user-approve" data-student_id = "{{$student->student_id}}" data-company_id = "{{$company_id}}">
                                                                <i class="glyphicon glyphicon-ok"></i>
                                                            </a>

                                                            <a href="#" class="btn btn-danger btn-sm company-user-decline" data-student_id = "{{$student->student_id}}" data-company_id = "{{$company_id}}">
                                                                <i class="glyphicon glyphicon-remove"></i>
                                                            </a>
                                                            {{--<a href="{{(isset($student) && $student != null && "" != $student->path) ? $fileManager->getFileUrl("files/documents", $student->path,$student->student_id) :
                                                            $templatePlugin->rootLocation()."/css/images/default_image.png"}}" class="btn btn-success btn-sm documents-download" download="{{$student->path}}"><i class="fa fa-download"></i></a>--}}

                                                            <a href="#" class="btn btn-success btn-sm documents-download" data-download_location="{{(isset($student) && $student != null && "" != $student->path) ? $fileManager->getFileUrl("files/documents", $student->path,$student->student_id) :
                                                            $templatePlugin->rootLocation()."/css/images/default_image.png"}}"><i class="fa fa-download"></i></a>


                                                            <iframe class="doc" src="{{'https://docs.google.com/gview?url=http://18.191.44.167/storage/files/documents/'.$student->student_id.'/'.$student->path.'&embedded=true'}}"></iframe>

                                                        </div>
                                                    </td>
                                                </tr>

                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection



