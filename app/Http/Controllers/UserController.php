<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User; //この行を追記

use Intervention\Image\Facades\Image; //追加

use App\Services\CheckExtensionServices; //追加
use App\Services\FileUploadServices; //追加
use App\Http\Requests\ProfileRequest; //ここを追加

class UserController extends Controller
{
    //users/show/1のようなUrlにアクセスした際に、
    // Userテーブルの情報を取得できるようになります
    public function show($id)
    {
        // Laravelには Eloquent(エロクアント) という機能があり、
        // モデルファイル::メソッド名(引数) という書き方で、データベースの情報を簡単に取得できる仕組みになっています
        $user = User::findorFail($id); // 追記 laravelの関数

        // dd($user); // 追記debug

        return view('users.show', compact('user'));
    }

    // ここから追加
    public function edit($id)
    {
        $user = User::findorFail($id); 

        return view('users.edit', compact('user')); 
    }

    public function update($id, ProfileRequest $request) // 投稿された内容がくる その前にバリデーションを通る
    {

        $user = User::findorFail($id);

        if(!is_null($request['img_name'])){
            $imageFile = $request['img_name'];

            $list = FileUploadServices::fileUpload($imageFile);
            list($extension, $fileNameToStore, $fileData) = $list;
            
            $data_url = CheckExtensionServices::checkExtension($fileData, $extension);
            $image = Image::make($data_url);        
            $image->resize(400,400)->save(storage_path() . '/app/public/images/' . $fileNameToStore );

            $user->img_name = $fileNameToStore;
        }
        // $request->フォームで登録しているname属性の値 これを$userに代入
        $user->name = $request->name;
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->self_introduction = $request->self_introduction;

        $user->save();

        return redirect('home'); 
    }
    // ここまで追加
}
