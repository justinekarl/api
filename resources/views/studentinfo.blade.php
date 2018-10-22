@extends('layout')

@section('css')

@endsection

@section('javascript')

@endsection

@section('content')
    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" >
        <thead>
        <tr>
            <th colspan="2" class="text-center">
                <b> MY INFORMATION </b>
            </th>
        </tr>
        </thead>

        <tbody>
        <tr>
            <td><strong>College:</strong></td>
            <td><strong>{{$student->college}}</strong></td>
        </tr>
        <tr>
            <td><strong>Course:</strong></td>
            <td><strong>{{$student->course}}</strong></td>
        </tr>
        <tr>
            <td><strong>Student Number:</strong></td>
            <td><strong>{{$student->studentnumber}}</strong></td>
        </tr>
        <tr>
            <td><strong>Name:</strong></td>
            <td><strong>{{$student->name}}</strong></td>
        </tr>
        <tr>
            <td><strong>Address:</strong></td>
            <td><strong>{{$student->address}}</strong></td>
        </tr>
        <tr>
            <td><strong>Phone Number:</strong></td>
            <td><strong>{{$student->phonenumber}}</strong></td>
        </tr>
        <tr>
            <td><strong>Email Address:</strong></td>
            <td><strong>{{$student->email}}</strong></td>
        </tr>
        <tr>
            <td><strong>Gender:</strong></td>
            <td><strong>{{$student->gender}}</strong></td>
        </tr>
        </tbody>

    </table>
@endsection
