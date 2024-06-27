<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// ここから追加
use App\Models\Reaction;
use App\Models\User;
use Auth;

use App\Constants\Status;
// ここまで追加

class MatchingController extends Controller
{
    //
    // ここから追加
    public static function index(){

        // 自分(to_user_id)へLIKEしてくれた人のIDを取得
        $got_reaction_ids = Reaction::where([
            //to_user_idが自分になる
            ['to_user_id', Auth::id()], 
            ['status', Status::LIKE]
            ])->pluck('from_user_id');

        // LIKEしてくれた人の中から、自分がLIKEした人だけを抽出
        $matching_ids = Reaction::whereIn('to_user_id', $got_reaction_ids)
        ->where('status', Status::LIKE) // status.phpで定義したLike=1
        ->where('from_user_id', Auth::id())
        ->pluck('to_user_id');
        // ↑
        // WhereInを使うことで、LIKEしてくれた人のidだけを検索しつつ、
        // 自分(この場合はfrom_user_id)がLIKEしている人を取得し、
        // 再度IDを取得　Laravelではコレクション型としてデータベースから情報を取得します

        $matching_users = User::whereIn('id', $matching_ids)->get();
        
        $match_users_count = count($matching_users);

        return view('users.index', compact('matching_users', 'match_users_count'));
    }
    // ここまで追加
}
