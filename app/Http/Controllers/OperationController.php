<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use PDO;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\Operations;


class OperationController extends Controller {

    public function getOperationList(){
        echo DB::table("operations")->get();
    }
}