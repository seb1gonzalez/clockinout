<?php

namespace App\Http\Controllers;

use DB;
use App\logs;
use Illuminate\Http\Request;

class logsController extends Controller
{
    public function clockinorout($pin)
    {
        $employee = DB::table('employees')->where('pin', $pin)->first();

        if($employee == NULL){
            return response()->json('Wrong PIN', 200);
        }

        if($employee->inorout){
            // log user out
            DB::table('employees')
            ->where('pin', $pin)
            ->update(['inorout' => 0]);
            // create log
            DB::table('logs')->insert(
                ['eId' => $employee->id, 'inorout' => 0]
            );
        }else{
            // log user in
            DB::table('employees')
            ->where('pin', $pin)
            ->update(['inorout' => 1]);
            // create log
            DB::table('logs')->insert(
                ['eId' => $employee->id, 'inorout' => 1]
            );
        }
        
    }
}