<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoomUser extends Model
{
    use HasFactory;
     // ここから追加8-1
    //  create()メソッドで保存する場合は、
    // 値を代入できるフィールドを指定しておく必要があります。
     protected $fillable = ['chat_room_id', 'user_id'];

     public function chatRoom()
     {
        //  chatroomuserは１つのチャットルームに存在
         return $this->belongsTo('App\Models\ChatRoom');
     }
 
     public function user()
     {
        //  chatroomuserは特定のuser情報をもつ
         return $this->belongsTo('App\Models\User');
     }
     // ここまで追加
}
