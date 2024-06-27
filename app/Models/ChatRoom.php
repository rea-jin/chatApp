<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    // use HasFactory;
    // ここから追加
    public function chatRoomUsers()
    {
        // ChatRoomモデルとChatRoomUsersが 1対多
        return $this->hasMany('App\Models\ChatRoomUser');
    }
    
    public function chatMessages()
    {
        // ChatRoomモデルとChatMessageモデルが 1対多
        return $this->hasMany('App\Models\ChatMessage');
    }
    // ここまで追加
}
