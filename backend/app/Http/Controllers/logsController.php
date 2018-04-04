<?php

namespace App\Http\Controllers;

use DB;
use App\logs;
use Illuminate\Http\Request;

class logsController extends Controller
{   
    public function userLogs($eId)
    {   
        $resposne = [];
        $logs = DB::table('logs')->where('time', 'LIKE', "%".date('Y-m-d')."%")->where('eId', $eId)->pluck('time');
        $response = [];
        foreach($logs AS $log){
            $temp_log = str_replace(date('Y-m-d') . " ", '', $log);
            array_push($response, $temp_log);
        }   

        return response()->json($response);        
    }
    
    public function usersLogs()
    {
        $usersin = DB::table('employees')->select('id', 'name')->get();
        $usersin =  json_decode(json_encode($usersin), True);
        $response = [];

        foreach($usersin AS $userin){
            $logs = DB::table('logs')->where('time', 'LIKE', "%".date('Y-m-d')."%")->where('eId', $userin['id'])->pluck('time');
            $responseItem = [];
            array_push($responseItem, $userin['id']);
            array_push($responseItem, $userin['name']);
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
            return response()->json(2, 200);
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

            return response()->json(0, 200);
            
        }else{
            // log user in
            DB::table('employees')
            ->where('pin', $pin)
            ->update(['inorout' => 1]);
            // create log
            DB::table('logs')->insert(
                ['eId' => $employee->id, 'inorout' => 1, 'name' => $employee->name]
            );

            return response()->json(1, 200);

        }
        
    }
}