<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Message extends Model
{
    use HasFactory;



    protected $fillable = array ( 'created_at', 'updated_at', 'message', 'type', 'user_id', 'agent_id', 'case_category_id', 'support_case_id', 'mail_id', 'mail_internetMessageId', 'mail_subject', 'mail_body_content', 'mail_weblink', 'mail_conversationId', 'mail_conversationIndex', 'mail_from', 'mail_sentDateTime', 'mail_receivedDateTime', 'mail_type', 'message_type', 'subject', 'mailto') ;   

public static function get_messages_vendor($casenumber)
{
//$messages=DB::select(DB::raw('SELECT messages.id as messageid, messages.created_at as created_at , users.name as name, users_with_role.mypic AS mypic, messages.message as message FROM (`messages` join `users` on(`messages`.`user_id` = `users`.`id`) join `users_with_role` on (`messages`.`user_id` = `users_with_role`.`id`)) WHERE support_case_id='.$casenumber.' AND message_type="vendor" ORDER BY messages.created_at DESC;'));

$messages = DB::table('messages')
            ->select('messages.id as messageid','messages.message as message','messages.mailto', 'messages.mail_conversationId','messages.created_at as created_at', 'messages.created_at as created_at', 'users.name as name', 'messages.mail_from as mail_from','users.mypic as mypic')
            ->leftJoin('users', 'messages.user_id', '=', 'users.id') //giati an den yparxei user den exei noima to join
            ->where('support_case_id', '=', $casenumber)
            ->where('message_type', '=', 'vendor')
            ->orderBy('messages.mail_conversationId', 'asc')
            ->orderBy('messages.created_at', 'desc')
            ->get()->toArray();

    

//dd($messages);





return $messages;
}

public static function save_mail_messages_vendor_incomming($a,$supportcase)
{
    //dd('INSERT INTO messages( mail_id, mail_internetMessageId, mail_subject, mail_body_content, mail_weblink, mail_conversationId, mail_conversationIndex, mail_from) VALUES ("'.$a['mail_id'].'","'.$a['mail_internetMessageId'].'","'.$a['mail_subject'].'","'.$a['mail_body_content'].'","'.$a['mail_weblink'].'","'.$a['mail_conversationId'].'","'.$a['mail_conversationIndex'].'","'.$a['mail_from'].'");');
//$messages=DB::raw('INSERT INTO messages( mail_id, mail_internetMessageId, mail_subject, mail_body_content, mail_weblink, mail_conversationId, mail_conversationIndex, mail_from) VALUES ("'.$a['mail_id'].'","'.$a['mail_internetMessageId'].'","'.$a['mail_subject'].'","'.$a['mail_body_content'].'","'.$a['mail_weblink'].'","'.$a['mail_conversationId'].'","'.$a['mail_conversationIndex'].'","'.$a['mail_from'].'");');

$messageid=DB::table('messages')->insertGetId([
    'mail_id' => $a['mail_id'],
    'support_case_id' => $supportcase,
    'mail_internetMessageId' => $a['mail_internetMessageId'],
    'mail_subject' => $a['mail_subject'],
    'mail_body_content' => $a['mail_body_content'],
    'message' => $a['mail_body_content'],
    'mail_weblink' => $a['mail_weblink'],
    'mail_conversationId' => $a['mail_conversationId'],
    'mail_conversationIndex' => $a['mail_conversationIndex'],
    'mail_from' =>$a['mail_from'],
    'message_type'=>'vendor'
]);








return $messageid;
}


public static function get_messages_client($casenumber)
{


    $messages=DB::select(DB::raw('SELECT messages.id as messageid, messages.created_at as created_at , users.name as name, users_with_role.mypic AS mypic, messages.message as message FROM (`messages` join `users` on(`messages`.`user_id` = `users`.`id`)    join `users_with_role` on (`messages`.`user_id` = `users_with_role`.`id`)) WHERE support_case_id='.$casenumber.' AND message_type="client" ORDER BY messages.created_at DESC;'));
   //dd($messages);

    return $messages;
}






}
