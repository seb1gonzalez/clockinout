<?php

namespace App\Http\Controllers;

use App\employee;
use Illuminate\Http\Request;

class employeeController extends Controller
{
    public function employeesOut()
    {   
        $employees = employee::where('inorout', '=', 0)->pluck('name');
        return $employees;
    }

    public function showAllEmployees()
    {   
        return response()->json(employee::all());
    }

    public function employee($id)
    {   
        return response()->json(employee::find($id));
    }

    public function addEmployee(Request $request)
    {
        $employee = employee::create($request->all());

        return response()->json($employee, 201);
    }

    public function updateEmployee($id, Request $request)
    {
        $employee = employee::findOrFail($id);
        $employee->update($request->all());

        return response()->json($employee, 200);
    }

    public function inorout($id, Request $request)
    {
        $employee = employee::findOrFail($id);

        if($employee->inorout){
            return response()->json('Employee is in', 200);
        }else{
            return response()->json('Employee is out', 200);
        }       
    }
}