<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use DateTime;

class ViewProject extends Model
{
    use HasFactory;

    //テーブルを指定する
    protected $table = 'view_projects';

    //Laravalでデフォルトで用意されている更新項目updated_atを「使用しない」に変更するための宣言
    const UPDATED_AT = null;
    const CREATED_AT = null;


    //$yearMonth : YYYY-MM
    //$keyWord : 案件No,案件名,顧客名。デフォルトは空文字。
    //$page : １ページあたりの最大件数

    //一覧画面用のデータ取得
    public static function getViewList($yearMonth="",$keyWord = "",$page = 50){

        if($yearMonth == ""){
            $yearMonth = date("Y-m");
        }
        $date = new DateTime($yearMonth);
        
        $rawQuery = "SELECT
            projects.id AS 'id',
            projects.name AS 'project_name',
            clients.name AS 'client_name',
            project_types.name AS 'type_name',
            (SELECT TIME_FORMAT(SUM(working_time),'%H:%i')
                FROM reports
                WHERE DATE_FORMAT(date,'%Y-%m') = '" . $date->format("Y-m") . "' AND reports.project_id = projects.id
                GROUP BY project_id , DATE_FORMAT(date,'%Y-%m')) AS 'month1',
            (SELECT TIME_FORMAT(SUM(working_time),'%H:%i')
                FROM reports
                WHERE DATE_FORMAT(date,'%Y-%m') = '" . $date->modify("-1 months")->format("Y-m") . "' AND reports.project_id = projects.id 
                GROUP BY project_id , DATE_FORMAT(date,'%Y-%m')) AS 'month2',
            (SELECT TIME_FORMAT(SUM(working_time),'%H:%i')
                FROM reports
                WHERE DATE_FORMAT(date,'%Y-%m') = '" . $date->modify("-1 months")->format("Y-m") . "' AND reports.project_id = projects.id 
                GROUP BY project_id , DATE_FORMAT(date,'%Y-%m')) AS 'month3',
            (SELECT TIME_FORMAT(SUM(working_time),'%H:%i')
                FROM reports
                WHERE reports.project_id = projects.id
                GROUP BY project_id) AS 'sum'
        FROM projects
        INNER JOIN clients ON projects.client_id = clients.id
        INNER JOIN project_types ON projects.project_type_id = project_types.id
        ";

        return \DB::table(\DB::raw("({$rawQuery}) as alias"))
        ->where("id","=",$keyWord)->orWhere("project_name","LIKE","%".$keyWord."%")
        ->orWhere("client_name","LIKE","%".$keyWord."%")
        ->orderBy("id", "desc")
        ->paginate($page);
    }
}
