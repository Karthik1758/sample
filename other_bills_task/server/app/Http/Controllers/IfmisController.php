<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddAgencyRequest;
use App\Http\Requests\EditAgencyRequest;
use App\Http\Requests\getAgencyRequest;
use App\Http\Requests\getFormTypeRequest;
use App\Http\Requests\getIfscCodeDetailsRequest;
use App\Models\Agency;
use App\Models\Form;
use App\Models\FormType;
use App\Models\IfscCode;
use Illuminate\Http\Request;

class IfmisController extends Controller
{
    public function getIfscCodeDetails(getIfscCodeDetailsRequest $request)
    {
        $ifsc_code = $request->get('ifsc_code');
        $details = IfscCode::where('ifsc_code', $ifsc_code)->first();
        return response()->json([
            "status" => true,
            "data" => $details,
        ]);
    }
    public function addAgency(AddAgencyRequest $request)
    {
        if (Agency::where('account_number', $request->account_number)->exists()) {
            return response()->json(['status' => false, "message" => "Agency Already Exists"]);
        }
        if (!IfscCode::where('ifsc_code', $request->ifsc_code)->exists()) {
            return response()->json(['status' => false, "message" => "Enter Valid IFSC Code"]);
        }

        $user = new Agency();
        $user->name = $request->get('name');
        $user->account_number = $request->get('account_number');
        $user->ifsc_code = $request->get('ifsc_code');
        $user->save();
        return response()->json(['status' => true, "message" => "Agency Added Successfully"]);
    }
    public function getAgency(getAgencyRequest $request)
    {
        $account_number = $request->get('account_number');
        $details = Agency::where('account_number', $account_number)->with('bankIfsc')->first();
        if (!$details) {
            return response()->json([
                "status" => false,
                "message" => 'Agency Not Found',
            ]);
        }
        return response()->json([
            "status" => true,
            "data" => $details,
            // "ifsc"=>$ifscDetails
        ]);
    }
    public function editAgency(EditAgencyRequest $request, Agency $agency)
    {
        if (!IfscCode::where('ifsc_code', $request->ifsc_code)->exists()) {
            return response()->json(['status' => false, "message" => "Enter Valid IFSC Code"]);
        }
        $agency->update($request->all());
        return response()->json(['status' => true, "message" => "Agency Updated Successfully"]);
    }
    public function getFormNumber()
    {
        $form = Form::all();
        return response()->json(['status' => true, "data" => $form]);
    }

    public function getFormType(getFormTypeRequest $request)
    {
        $form_number_id = $request->get('form_number_id');
        $FormTypes = FormType::where('form_number_id', $form_number_id)->get();
        if (count($FormTypes)==0) {
            return response()->json([
                "status" => false,
                "message" => 'Form type Not Found',
            ]);
        }
        return response()->json([
            "status" => true,
            "data" => $FormTypes,
        ]);
    }
}