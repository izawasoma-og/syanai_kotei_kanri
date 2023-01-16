<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use PDO;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\Project;
use App\Models\ProjectType;
use App\Models\Client;
use App\Http\Requests\ProjectRequest;
use App\Models\ViewProject;
use DateTime;

class ProjectController extends Controller {

    //案件一覧画面
    public function projectList(Request $req) {

        $assign = [];

        //入力された値の調整
        $startMonth = $req->has("month") ? $req->input("month") : date("Y-m");
        $assign["month"] = $startMonth;
        $key = $req->has("key") ? $req->input("key") : "";
        $assign["key"] = $key;

        //=====================================
        //●直近三ヶ月のカラムの作成準備
        //=====================================

        //現在の月を取得
        $date = new DateTime($startMonth);
        //過去何ヶ月分遡るか
        $backCount = 3;
        //表示用配列
        $months = [];

        for($i=0; $i<$backCount; $i++){
            //表示する文字列を格納
            $months[] = $date->format("Y")."年\n".$date->format("n")."月";
            //一ヶ月カウントアップ
            $date->modify('-1 months');
        }

        $assign["months"] = array_reverse($months, true);
        $assign["projects"] = ViewProject::getViewList($startMonth,$key,50);

        return view('project.projectList',$assign);
    }

    //案件追加画面
    public function projectAdd() {
        $assign = [];
        $assign["projectTypes"] = DB::table("project_types")->get();
        return view('project.projectAdd',$assign);
    }

    //[API]プロジェクト一覧取得
    public function getProjectList(){
        $datas = DB::table("projects")
        ->leftjoin("clients","projects.client_id","=","clients.id")
        ->leftjoin("project_types","projects.project_type_id","=","project_types.id")
        ->select("projects.id as id","projects.name as project_name","project_types.name as type_name","clients.name as client_name")
        ->sharedLock()
        ->get();
        echo json_encode($datas);
    }

    //追加画面で追加ボタンを押した時の処理
    public function projectInsert(ProjectRequest $req){
        //トランザクションの宣言
        DB::beginTransaction();
        //登録処理
        try{
            //案件情報の登録
            $project = new Project();
            $project->client_id = $req->formClientId;
            $project->project_type_id = $req->formProjectType;
            $project->name = $req->formName;
            $project->save();

            //トランザクションをコミット
            DB::commit();

            $lastInsertId = $project->id;
            return redirect("projectList")->with("flashMsg", "登録成功：案件id ".$lastInsertId." 番で案件情報を登録しました。");
        }
        catch(\Exception $e){
            //トランザクションをロールバック
            DB::rollBack();
            \Log::info($e);
            exit;
        }
    }

    //顧客追加画面
    public function projectEdit(Request $req) {
        $assign = [];
        $assign["projectTypes"] = DB::table("project_types")->get();
        $assign["project"] = DB::table("projects")->where("id","=",$req->id)->sharedLock()->get()[0];
        return view('project.projectEdit',$assign);
    }

    //追加画面で追加ボタンを押した時の処理
    public function projectUpdate(ProjectRequest $req){
        //トランザクションの宣言
        DB::beginTransaction();
        //登録処理
        try{
            //商品情報の編集
            DB::table("projects")
            ->where("id", $req->id)
            ->update(['client_id' => $req->formClientId,'project_type_id' => $req->formProjectType,'name' => $req->formName,]);

            //トランザクションをコミット
            DB::commit();

            return redirect("projectList")->with("flashMsg", "更新完了：顧客id ".$req->id." 番の案件情報を修正しました");
        }
        catch(\Exception $e){
            //トランザクションをロールバック
            DB::rollBack();
            \Log::info($e);
            exit;
        }
    }
}
