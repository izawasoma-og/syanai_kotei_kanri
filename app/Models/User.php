<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    //テーブルを指定する
    protected $table = 'users';
    
    //Laravalでデフォルトで用意されている更新項目「使用しない」に変更するための宣言
    const UPDATED_AT = null;
    const CREATED_AT = null;

    //INSERT実行時に登録する項目を設定
    protected $fillable = [
        'name',
        'email',
        'password',
        'memo',
        'authority_types_id',
    ];

    //セレクト文を実行した際に表示しない項目を設定
    protected $hidden = [
        'password',
        'remember_token',
    ];

    //取得時に変換が必要なカラムを設定
    protected $casts = [
        'email_verified_at' => 'datetime',
        'deleted' => 'boolean',
    ];
}
