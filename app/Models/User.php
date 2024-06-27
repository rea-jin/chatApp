<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'self_introduction', 
        'gender', 
        'img_name'
    
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relation
    // ここから下を追記 hasMany(相手のモデル名, 相手モデルのID, 自モデルのID)
    public function toUserId()
    {
        return $this->hasMany('App\Models\Reaction', 'to_user_id', 'id');
    }

    public function fromUserId()
    {
        return $this->hasMany('App\Models\Reaction', 'from_user_id', 'id');
    }

    // ここから追加
    public function chatMessages()
    {
        // userはchatmessageをたくさん持つ
        return $this->hasMany('App\Models\ChatMessage');
    }

    public function chatRoomUsers()
    {
        // userはchatroomをたくさん持つ
        return $this->hasMany('App\Models\ChatRoomUsers');
    }
    // ここまで追加

}
