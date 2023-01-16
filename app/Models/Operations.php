<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class Operations extends Model
{
    use HasFactory;

    //テーブルを指定する
    protected $table = 'operations';

    //Laravalでデフォルトで用意されている更新項目updated_atを「使用しない」に変更するための宣言
    const UPDATED_AT = null;
    const CREATED_AT = null;

    //INSERTを実行する際、登録しないデータ項目を設定
    protected $guarded = [
        'id',
        'deleted',
    ];

    //INSERTを実行する際、登録するデータ項目を設定
    protected $fillable = [
        'name',
    ];
}
