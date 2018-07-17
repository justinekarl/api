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
                <strong>Login Date/Time In</strong>
            </td>
            <td>
                <strong>Logout Date/Time Out</strong>
            </td>
            <td>
                <strong>Logged in through</strong>
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
                {{null != $log->login_date ?  date('Y-m-d h:i:s a',strtotime($log->login_date)) : "" }}
            </td>
            <td>
                {{null != $log->logout_date ? date('Y-m-d h:i:s a',strtotime($log->logout_date)) : ""}}
            </td>
            <td>
                {{$log->finger_print_scanner ? 'Finger Print' : 'QR Code'}}
            </td>
        </tr>
        @endforeach
    </table>

</html>