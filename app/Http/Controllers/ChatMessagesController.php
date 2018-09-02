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
}
