<?php

namespace App\Http\Controllers;

use DB;
use App\logs;
use Illuminate\Http\Request;

class logsController extends Controller
{
    public function usersLogs()
    {
        $usersin = DB::table('logs')->distinct()->where('time', 'LIKE', "%".date('Y-m-d')."%")->pluck('name');
        $response = [];

        foreach($usersin AS $userin){
            $logs = DB::table('logs')->where('time', 'LIKE', "%".date('Y-m-d')."%")->where('name', $userin)->pluck('time');
            $responseItem = [];
            array_push($responseItem, $userin);
            foreach($logs AS $log){
                $temp_log = str_replace(date('Y-m-d') . " ", '', $log);
                array_push($responseItem, $temp_log);
            }
            array_push($response, $responseItem);
        }
        return response()->json($response);        
    }

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
                ['eId' => $employee->id, 'inorout' => 0, 'name' => $employee->name]
            );

            return response()->json($employee->name . ' clocked out successfully', 200);
            
        }else{
            // log user in
            DB::table('employees')
            ->where('pin', $pin)
            ->update(['inorout' => 1]);
            // create log
            DB::table('logs')->insert(
                ['eId' => $employee->id, 'inorout' => 1, 'name' => $employee->name]
            );

            return response()->json($employee->name . ' clocked in successfully', 200);

        }
        
    }
}