<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddEmployee;
use App\Http\Requests\AddLeave;
use App\Http\Requests\editEmployee;
use App\Http\Requests\getEmployeeDetails;
use App\Http\Requests\GetEmployeeLeaves;
use App\Http\Requests\loginRequest;
use App\Models\employee;
use App\Models\Leave;
use Illuminate\Http\Request;

class employeeController extends Controller
{
    public function login(loginRequest $loginRequest)
    {
        $user = employee::where('email', $loginRequest->get('email'))->first();
        if (!$user) {
            return response()->json(['status' => false, 'message' => "Invalid Email"]);
        }
        if ($user["password"] == $loginRequest->get("password")) {
            $bytes = random_bytes(5);
            $token=  bin2hex($bytes);
            return response()->json(['status' => true, "message" => "Login Successful","data"=>$token]);
        }
       
        return response()->json(['status' => false, 'message' => "Invalid Password"]);
    }

    public function AddEmployee(AddEmployee $request)
    {

        if (employee::where('email', $request->get('email'))->exists()) {
            return response()->json(['status' => false, "message" => "Email already Exists"]);
        }
        if (employee::where('phone_number', $request->get('phone_number'))->exists()) {
            return response()->json(['status' => false, "message" => "Phone Number already Exists"]);
        }

        $user = new employee();
        $user->full_name = $request->get('full_name');
        $user->dob = $request->get('dob');
        $user->phone_number = $request->get('phone_number');
        $user->email = $request->get('email');
        $user->gender = $request->get('gender');
        $user->password = $request->get('password');
        $user->save();

        return response()->json(['status' => true, "message" => "Employee Added Successfully"]);
    }

    public function getEmployees(){
        $employees = employee::paginate(1);
        return response()->json(['status' => true, "data" => $employees]);
    }

    // public function getEmployeeDetails(getEmployeeDetails $request){
    //     $id = $request->get('id');
    //     $details = employee::where('id', $id)->first();
    //     return response()->json([
    //         "status" => true,
    //         "data" => $details,
    //     ]);
    // }

    public function editEmployee(editEmployee $request, employee $employee) {
        $employee->update($request->all());
        return response()->json(['status' => true, "message" => "Employee Updated Successfully"]);
    }


    public function AddLeave(AddLeave $request)
    {
        
        if (Leave::where('employee_id', $request->get('employee_id'))->where('from', $request->get('from'))->where('to', $request->get('to'))->exists()) {
            return response()->json(['status' => false, "message" => "Leave already Exists"]);
        }

        $user = new Leave();
        $user->employee_id = $request->get('employee_id');
        $user->from = $request->get('from');
        $user->to = $request->get('to');
        $user->type = $request->get('type');
        $user->reason = $request->get('reason');
        $user->save();

        return response()->json(['status' => true, "message" => "Leave Applied Successfully"]);
    }

    public function GetEmployeeLeaves(GetEmployeeLeaves $request){
        $employee_id = $request->get('employee_id');
        $details = Leave::where('employee_id', $employee_id)->get();
        return response()->json([
            "status" => true,
            "data" => $details,
        ]);
    }
    public function getEmployeeDetails(getEmployeeDetails $request){
        $id = $request->get('id');
        $employees = employee::where('id', $id)->with('Leave')->first();
        return response()->json($employees);
    }
}



