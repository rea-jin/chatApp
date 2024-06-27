<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    // use HasFactory;
    // ここから追加
    public $incrementing = false;  // インクリメントIDを無効化
    public $timestamps = false; // update_at, created_at を無効化

    // Relation
    // Reactionモデルからそれぞれ1つのidを参照したいので、belongsToメソッドを使います。
    // belongsTo(相手のモデル名, 自モデルのID, 相手のID名)
    public function toUserId()
    {
        return $this->belongsTo('App\Models\User', 'to_user_id', 'id');
    }

    public function fromUserId()
    {
        return $this->belongsTo('App\Models\User', 'from_user_id', 'id');
    }
}
