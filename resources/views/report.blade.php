<html>
    <table colspan=5 rowspan=5 border=3>
        <tr>
            <td>
                Student Name
            </td>
            <td>
                Company
            </td>
            <td>
                Time In
            </td>
            <td>
                Time Out
            </td>
            <td>
                Scanned at
            </td>
        </tr>

        @foreach($logs as $log)
        <tr>
            <td>
                {{$log->name}}
            </td>
             <td>
                {{$log->company_name}}
            </td>
            <td>
                {{date('Y-m-d h:i:s a',strtotime($log->login_date))}}
            </td>
            <td>
                {{date('Y-m-d h:i:s a',strtotime($log->logout_date))}}
            </td>
            <td>
                {{$log->finger_print_scanner ? 'Office' : 'field'}}
            </td>
        </tr>
        @endforeach
    </table>

</html>