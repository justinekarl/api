  @extends('layout')

@section('css')

@endsection

@section('javascript')

@endsection

@section('content')
    <div align="center">
    <strong>OJT LOGS</strong>
    </div>
    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" >
        <tbody>
        <tr>
            <td><strong>Name:</strong></td>
            <td><strong>Company Name:</strong></td>
            <td><strong>Login:</strong></td>
            <td><strong>Logout:</strong></td>
        </tr>
        @foreach($logs1 as $log)
        <tr>
            
            <td><strong>{{isset($log) ? $log->student_name : ''}}</strong></td>
            <td><strong>{{isset($log) ? $log->company_name : ''}}</strong></td>
            <td><strong>{{isset($log) ? $log->login : ''}}</strong></td>
            <td><strong>{{isset($log) ? $log->logout : ''}}</strong></td>
        </tr>
        @endforeach
        <tr>
            
            
        </tr>
        
    </tbody>

    </table>

@endsection


