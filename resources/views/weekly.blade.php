<html>
    <table colspan=5 rowspan=5 border=3>
        <tr>
            <td>
                <strong>Student Name</strong>
            </td>
            <td>
                <strong>Company</strong>
            </td>
            <td>
                <strong>Accumulated Hours</strong>
            </td>
        </tr>

        @foreach($logs as $log)
        <tr>
            <td>
                {{$log->student_name}}
            </td>
             <td>
                {{$log->company_name}}
            </td>
            <td>
                {{date('H:i',strtotime($log->accumulated_time))}} Hour/s
            </td>
        </tr>
        @endforeach
    </table>

</html>