<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use PDO;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Http\Requests\ReportRequest;
use App\Models\Operations;
use App\Models\Report;
use App\Models\ViewReport;
use DateTime;

class ReportController extends Controller {

    //日報一覧画面
    public function reportList(Request $req) {
        $assign = [];

        //検索キーワード
        $assign["key"] = $req->key;
        $key = $req->key;

        //検索日時
        $assign["date_start"] = $req->date_start;
        $date_start = $req->date_start;
        $assign["date_end"] = $req->date_end;
        $date_end = $req->date_end;

        $assign["reports"] = ViewReport::when(isset($req->date_start), function($query) use ($date_start){
            return $query->where("date",">=",$date_start);
        })
        ->when(isset($req->date_end), function($query) use ($date_end){
            return $query->where("date","<=",$date_end);
        })
        ->when(isset($req->key), function($query) use ($key){
            return $query->where(function($query) use ($key){
                return $query->where("project_id",$key)->orWhere("project_name","LIKE","%".$key."%")->orWhere("clients_name","LIKE","%".$key."%");
            });
        })
        ->orderBy("date","desc")
        ->orderBy("id","desc")
        ->paginate(50);
        
        $nowPage = is_null($req->input("page")) ? 1 : $req->input("page");

        $assign["count"] = ViewReport::all()->count();
        $assign["start"] = ( $nowPage - 1 ) * 10 + 1;
        $assign["end"] = $nowPage * 10;
        if($assign["end"] > $assign["count"]){
            $assign["end"] = $assign["count"];
        }
        
        $assign["countMsg"] = $assign["count"] . "件中 " . $assign["start"] . "件目 ~ " . $assign["end"] . "件目";
        
        return view('report.reportList',$assign);
    }

    //案件追加画面
    public function reportAdd() {
        $assign = [];
        $assign["operations"] = Operations::all();
        return view('report.reportAdd',$assign);
    }

    //追加画面で追加ボタンを押した時の処理
    public function reportInsert(ReportRequest $req){
        $reports = $req->input("report");
        //トランザクションの宣言
        DB::beginTransaction();
        $insert_reports = [];
        //登録処理
        try{
            foreach($reports as $report){
                $insert_report["project_id"] = $report["project_id"];
                $insert_report["user_id"] = Auth::user()->id;
                $insert_report["operation_id"] = $report["operation_id"];
                $insert_report["date"] = $req->input("date");
                $insert_report["working_time"] = $report["working_time"];
                $insert_report["url"] = $report["url"] == "http://dammy" ? null : $report["url"];
                $insert_reports[] = $insert_report;
            }
            //案件情報の登録
            Report::insert($insert_reports);
            //トランザクションをコミット
            DB::commit();

            //登録件数を取得
            $count = count($insert_reports);
            return redirect("reportList")->with("flashMsg", "日報を" . $count . "件登録しました。");
        }
        catch(\Exception $e){
            //トランザクションをロールバック
            DB::rollBack();
            \Log::info($e);
            exit;
        }
    }

    //[API]レポート更新
    public function putReport(Request $req){
        if($req->editOperationId == "4" && !isset($req->editUrl)){
            return response('url is null', 400)->header('Content-Type', 'text/plain');
        }
        //トランザクションの宣言
        DB::beginTransaction();
        //登録処理
        try{
            $report = Report::find($req->editId);
            $report->project_id = $req->editProjectId;
            $report->operation_id = $req->editOperationId;
            $report->date = $req->editDate;
            $report->working_time = $req->editWorkingTime;
            if(isset($req->editUrl)){
                $report->url = $req->editUrl;
            }
            else{
                $report->url = null;
            }
            $report->save();
            //トランザクションをコミット
            DB::commit();
            return response('complete', 200)->header('Content-Type', 'text/plain');
        }
        catch(\Exception $e){
            DB::rollBack();
            \Log::info($e);
            return response('data update failed', 400)->header('Content-Type', 'text/plain');
        }
    }
}