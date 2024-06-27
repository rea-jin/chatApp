<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;
    // ここから追加8-1
    protected $fillable = ['chat_room_id', 'user_id', 'message'];

    public function chatRoom()
    {
        // chatmessageは1つのチャットる＾無に存在する
        return $this->belongsTo('App\Models\ChatRoom');
    }

    public function user()
    {
        // チャットメッセージは特定のユーザーが持つ
        return $this->belongsTo('App\Models\User');
    }
    // ここまで追加
}
