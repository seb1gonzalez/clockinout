<?php

namespace App\Http\Controllers;

use DB;
use App\logs;
use Illuminate\Http\Request;

class logsController extends Controller
{   
    public function weeklyLog($eId)
    {   
        $weekStart = json_decode(json_encode(new \DateTime("last sunday")), True);
        $date = $weekStart['date'];
        $logs = DB::table('logs')->where('time', '>', $date)->where('eId', $eId)->orderBy('time', 'asc')->pluck('time');
        return response()->json($logs);                
    }

    public function userLogs($eId)
    {   
        $resposne = [];
        $logs = DB::table('logs')->where('time', 'LIKE', "%".date('Y-m-d')."%")->where('eId', $eId)->orderBy('time', 'asc')->pluck('time');
        $response = [];
        foreach($logs AS $log){
            $temp_log = str_replace(date('Y-m-d') . " ", '', $log);
            array_push($response, $temp_log);
        }   

        return response()->json($response);        
    }
    
    public function usersLogs()
    {
        $usersin = DB::table('employees')->select('id', 'name')->orderBy('name', 'asc')->get();
        $usersin =  json_decode(json_encode($usersin), True);
        $response = [];

        foreach($usersin AS $userin){
            $logs = DB::table('logs')->where('time', 'LIKE', "%".date('Y-m-d')."%")->where('eId', $userin['id'])->orderBy('time', 'asc')->pluck('time');
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
                ['eId' => $employee->id, 'inorout' => 0, 'name' => $employee->name, 'flag' => 0]
            );

            return response()->json(0, 200);
            
        }else{
            // log user in
            DB::table('employees')
            ->where('pin', $pin)
            ->update(['inorout' => 1]);
            // create log
            DB::table('logs')->insert(
                ['eId' => $employee->id, 'inorout' => 1, 'name' => $employee->name, 'flag' => 0]
            );

            return response()->json(1, 200);

        }
        
    }
}