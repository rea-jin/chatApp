<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User; //追加
use Auth; //追加



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // return view('home');
        $users = User::all(); //追加

        // return view('home', compact('users')); //追加
        $userCount = $users->count(); // 追加 全ユーザーの数を取得
        $from_user_id = Auth::id(); // 追加
        // $from_user_id変数は 現在ログインしているユーザーのIDを取得
        // compactメソッドを使うことで、複数の変数をビュー側へ渡すことができます
        return view('home', compact('users', 'userCount', 'from_user_id')); // 追加
    }
}
