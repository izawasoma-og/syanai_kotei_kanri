<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use PDO;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Http\Requests\PasswordUpdateRequest;

class UserController extends Controller {

    //パスワード変更画面
    public function goPassUpdate() {
        $assign = [];
        return view('user.passUpdate',$assign);
    }

    //パスワード変更
    public function passUpdate(PasswordUpdateRequest $req) {
        $hashed_pass = \Hash::make($req->newPass);
        //トランザクションの宣言
        DB::beginTransaction();
        //登録処理
        try{
            //商品情報の編集
            DB::table("users")
            ->where("id","=",Auth::user()->id)
            ->update(['password' => $hashed_pass]);
            //トランザクションをコミット
            DB::commit();
        }
        catch(\Exception $e){
            //トランザクションをロールバック
            DB::rollBack();
            \Log::info($e);
            exit;
        }
        
        return redirect("passUpdateComp");
    }

    //パスワード変更完了
    public function passUpdateComp() {
        return view('user.passUpdateComp');
    }
}