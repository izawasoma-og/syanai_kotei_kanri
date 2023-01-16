<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\PassResetMail;
use Illuminate\Support\Facades\DB;

class passreset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'passreset {mail}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $mail = $this->argument("mail");
        $user = new User();
        $count = $user->where("email","=",$mail)->count();
        
        if($count > 0){
            $str = '1234567890abcdefghijklmnopqrstuvwxyz';
            $new_pass = substr(str_shuffle($str), 0, 12);
            $hashed_pass = \Hash::make($new_pass);
    
            print_r("\n");
            print_r("========= GENERATED NEW PASSWORD!!! ========\n");
            print_r("\n");
            print_r("【 NEW   PASSWORD 】▼" . "\n" . $new_pass . "\n");
            print_r("\n");
            print_r("【HASHED PASSWORD 】▼" . "\n" . $hashed_pass . "\n");
            print_r("\n");
            print_r("=============================================\n");
            print_r("\n");

            //トランザクションの宣言
            DB::beginTransaction();
            //登録処理
            try{
                //商品情報の編集
                DB::table("users")
                ->where("email","=",$mail)
                ->update(['password' => $hashed_pass]);

                //トランザクションをコミット
                DB::commit();

                //password変更通知メール送信
                Mail::to($mail)->send(new PassResetMail($new_pass));
            }
            catch(\Exception $e){
                //トランザクションをロールバック
                DB::rollBack();
                \Log::info($e);
                print_r("ERROR!!! : DB ERROR");
                print_r("ERROR!!! : Please check log file.");
                exit;
            }

        }
        else{
            print_r("ERROR!!! : email not found.");
        }


        return Command::SUCCESS;
    }
}
