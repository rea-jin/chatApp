<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Intervention\Image\Facades\Image; //ここを追記
use App\Services\CheckExtensionServices; // 作成したファイル
use App\Services\FileUploadServices; //追加


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'img_name' => ['required','file', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2000'], //この行を追加します
            'self_introduction' => ['string', 'max:255'], //この行を追加します
        ]);
        
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data modelで使う
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // return User::create([
            // 'name' => $data['name'],
            // 'email' => $data['email'],
            // 'password' => Hash::make($data['password']),
            // //以下を追加
            // 'self_introduction' => $data['self_introduction'],
            // 'gender' => $data['gender'],
            // 'img_name' => $data['img_name'],
dump($data);
        // ---ここから追加---
        //引数 $data から name='img_name'を取得(アップロードするファイル情報)
        $imageFile = $data['img_name'];
        $list = FileUploadServices::fileUpload($imageFile); //変更
        list($extension, $fileNameToStore, $fileData) = $list; // 追加 php list()　それぞれ割り当てる

        //拡張子ごとに base64エンコード実施　戻り値 = サービスクラス名::メソッド名(引数)
        //アクセス修飾子をpublic staticと指定していたため、クラス名::メソッド名 として静的メソッドとして呼び出すことができます。
        $data_url = CheckExtensionServices::checkExtension($fileData, $extension); //ここを変更しています。

        //画像アップロード(Imageクラス makeメソッドを使用)
        $image = Image::make($data_url);

        //画像を横400px, 縦400pxにリサイズし保存　パスが違うような気がするが保存されている。strage/は書かなくてもいい？
        $image->resize(400,400)->save(storage_path() . '/app/public/images/' . $fileNameToStore );
        // ---ここまで追加---

        //createメソッドでユーザー情報を作成
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'self_introduction' => $data['self_introduction'],
            'gender' => $data['gender'],
            
            // ここを変更
            'img_name' => $fileNameToStore,
        ]);
    }
}
