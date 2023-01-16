<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use PDO;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\Client;
use App\Http\Requests\ClientRequest;

class ClientController extends Controller {

    //顧客一覧画面
    public function clientList(Request $req) {
        $assign = [];

        //検索キーワード
        $assign["keyword"] = $req->key;

        //idのソート
        //viewに渡すソート条件を設定
        if(is_null($req->sort)){
            $assign["sort"] = "desc";
        }
        else{
            $assign["sort"] = $req->sort;
        }
        //ソートボタンのクラスの設定
        $assign["up"] = "text-white";
        $assign["down"] = "text-muted link-btn-disable";
        if($req->sort == "asc"){
            $assign["up"] = "text-muted link-btn-disable";
            $assign["down"] = "text-white";
        }
        
        $assign["clients"] = DB::table("clients")
        ->where("name","LIKE","%".$assign["keyword"]."%")
        ->orderBy('id', $assign["sort"])
        ->sharedLock()
        ->paginate(50);
        return view('client.clientList',$assign);
    }

    //顧客追加画面
    public function clientAdd() {
        return view('client.clientAdd');
    }

    //追加画面で追加ボタンを押した時の処理
    public function clientInsert(ClientRequest $req){
        //トランザクションの宣言
        DB::beginTransaction();
        //登録処理
        try{
            //商品情報の登録
            $client = new Client();
            $client->name = $req->formName;
            $client->save();

            //トランザクションをコミット
            DB::commit();

            $lastInsertId = $client->id;
            return redirect("clientList")->with("flashMsg", "登録成功：顧客id ".$lastInsertId." 番で顧客情報を登録しました。");
        }
        catch(\Exception $e){
            //トランザクションをロールバック
            DB::rollBack();
            \Log::info($e);
            exit;
        }
    }

    //顧客追加画面
    public function clientEdit(Request $req) {
        $assign = [];
        $assign["client"] = DB::table("clients")->where("id","=",$req->id)->sharedLock()->get()[0];
        return view('client.clientEdit',$assign);
    }

    //追加画面で追加ボタンを押した時の処理
    public function clientUpdate(ClientRequest $req){
        //トランザクションの宣言
        DB::beginTransaction();
        //登録処理
        try{

            //商品情報の編集
            DB::table("clients")
            ->where("id", $req->id)
            ->update(['name' => $req->formName]);

            //トランザクションをコミット
            DB::commit();

            return redirect("clientList")->with("flashMsg", "更新完了：顧客id ".$req->id." 番の顧客情報を修正しました");
        }
        catch(\Exception $e){
            //トランザクションをロールバック
            DB::rollBack();
            \Log::info($e);
            exit;
        }
    }

    public function getClientList(){
        echo DB::table("clients")->get();
    }
}