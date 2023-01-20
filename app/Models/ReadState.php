<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Models\User;
class ReadState extends Model
{
    use HasFactory;
    protected $table = 'read_state';



    public static function mark_unread($item_id,$item_type)
    {
        $users = User::where('id', '!=', auth()->id())->get();
foreach($users as $user)
{

    $result=DB::table('read_state')->insert([
        'item_id' => $item_id,
        'item_type' => $item_type,
        'read' => False,
        'user_id'=> $user->id,
    ]);
    

}
    //gia ton agent pou yo ftiaxnei
$result=DB::table('read_state')->insert([
    'item_id' => $item_id,
    'item_type' => $item_type,
    'read' => True,
    'user_id'=> auth()->id(),
]);   
   //gia ton agent pou yo ftiaxnei  
    
    
    return $result;
    }






    public static function mark_read_user($item_id,$item_type,$user_id)
    {
            $result=DB::table('read_state')->where('item_id','=',$item_id)->where('item_type','=',$item_type)->where('user_id','=',$user_id)->update(['read' => True]);
    return $result;
    }


    public static function  number_unread_user($item_type,$user_id)
    {
        $dbresult=DB::table('read_state')->where('item_type','=',$item_type)->where('user_id','=',$user_id)->where('read','=',False)->get();
        $result = $dbresult->count();
   
   
        return $result;
    }

   











}
