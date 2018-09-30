<?php

namespace App\Http\Controllers;

use App\ChatMessages;
use App\Http\Resources\MessageResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatMessagesController extends Controller
{
    public function sendMessage(Request $request){

        $chat = new ChatMessages();
        $chat->message = $request->input("message");
        $chat->sender_id = $request->input("sender_id");
        $chat->receiver_id = $request->input("receiver_id");
        $chat->save();

        $sender_id = $request->input("sender_id");
        $receiver_id = $request->input("receiver_id");

        $sql = " SELECT DISTINCT * ";
        $sql .= " FROM ( ";
        $sql .= "   SELECT *,(SELECT username FROM user WHERE id = sender_id) as sender ";
        $sql .= "   FROM chat_messages ";
        $sql .= "   WHERE sender_id = {$sender_id} AND receiver_id = {$receiver_id} ";
        $sql .= "   UNION ";
        $sql .= "   SELECT * ,(SELECT username FROM user WHERE id = sender_id) as sender";
        $sql .= "   FROM chat_messages ";
        $sql .= "   WHERE sender_id = {$receiver_id} AND receiver_id = {$sender_id}) a ";
        $sql .= "ORDER BY created_at ";

        $result = DB::select( DB::raw($sql));

        /* DB::table('chat_messages')
            ->where('sender_id', $sender_id)
            ->update(['is_read' => 1]);*/

        return response()->json([
            "response" => true,
            "message" => $result
        ]);
    }

    public function getMessage(Request $request){
        $sender_id = $request->input("sender_id");
        $receiver_id = $request->input("receiver_id");

        $sql = " SELECT DISTINCT * ";
        $sql .= " FROM ( ";
        $sql .= "	SELECT *,(SELECT username FROM user WHERE id = sender_id) as sender ";
        $sql .= "	FROM chat_messages ";
        $sql .= "	WHERE sender_id = {$sender_id} AND receiver_id = {$receiver_id} ";
        $sql .= "	UNION ";
        $sql .= "	SELECT * ,(SELECT username FROM user WHERE id = sender_id) as sender";
        $sql .= "	FROM chat_messages ";
        $sql .= "	WHERE sender_id = {$receiver_id} AND receiver_id = {$sender_id}) a ";
        $sql .= "ORDER BY created_at ";



        $result = DB::select( DB::raw($sql));

/*
        DB::table('chat_messages')
            ->where('sender_id', $sender_id)
            ->update(['is_read' => 1]);
*/
        return response()->json([
            "response" => true,
            "message" => $result
        ]);
    }

    public function getLatestMessage($receiver_id){
        //$sender_id = $request->input("sender_id");
       // $receiver_id = $request->input("receiver_id");

        $sql = " select chat_messages.*,user.username from chat_messages left join user on user.id = chat_messages.sender_id where receiver_id = {$receiver_id} and not is_read order by chat_message_id desc limit 1 ";
        $result = DB::select( DB::raw($sql));

        DB::table('chat_messages')
            ->where('receiver_id', $receiver_id)
            ->update(['is_read' => 1]);

     $response = sizeof($result) > 0 ? true : false;
     $message = '';
     $sender = '';
     $receiverId = '';
     $senderId = '';
     $updates = '';

     if($response){
        $message = $result[0]->message;
        $sender = $result[0]->username;
        $receiverId = $result[0]->receiver_id;
        $senderId = $result[0]->sender_id;

      /*   $sql = " SELECT DISTINCT * ";
        $sql .= " FROM ( ";
        $sql .= "   SELECT *,(SELECT username FROM user WHERE id = sender_id) as sender ";
        $sql .= "   FROM chat_messages ";
        $sql .= "   WHERE sender_id = {$sender_id} AND receiver_id = {$receiver_id} ";
        $sql .= "   UNION ";
        $sql .= "   SELECT * ,(SELECT username FROM user WHERE id = sender_id) as sender";
        $sql .= "   FROM chat_messages ";
        $sql .= "   WHERE sender_id = {$receiver_id} AND receiver_id = {$sender_id}) a ";
        $sql .= "ORDER BY created_at ";

        $updates = DB::select( DB::raw($sql));*/


     }
        return response()->json([
            "response" => $response,
            "message" => $message,
            "sender" => $sender,
            "receiverId" => $receiverId,
            "senderId" => $senderId,
            "updates" => $updates
        ]);
    }

    public function getLatestStudentLog($student_id){
         $sql = " select DATE_FORMAT(login_date,'%h:%i:%s %p') as login_date,DATE_FORMAT(logout_date,'%h:%i:%s %p') as logout_date,user.name as company_name  from student_ojt_attendance_log
            LEFT JOIN user ON user.id = student_ojt_attendance_log.company_id AND user.accounttype = 3 where cast(scan_date as date) = current_date AND is_read IS FALSE AND student_id = {$student_id} order by student_ojt_attendance_log.id desc limit 1 ";

         error_log($sql);

         $result = DB::select( DB::raw($sql));

         $updateSQL = "UPDATE student_ojt_attendance_log SET is_read = TRUE WHERE cast(scan_date as date) = current_date AND is_read IS FALSE AND student_id = {$student_id} ";

         $result1 = DB::update(DB::raw($updateSQL));

         error_log($updateSQL);
         error_log($updateSQL);

         return response()->json([
            "response" => true,
            "log" => $result
        ]);
    }
}
