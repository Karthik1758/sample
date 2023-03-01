<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddAgencyRequest;
use App\Http\Requests\EditAgencyRequest;
use App\Http\Requests\getAgencyRequest;
use App\Http\Requests\getFormTypeRequest;
use App\Http\Requests\getIfscCodeDetailsRequest;
use App\Http\Requests\SubmitBillRequest;
use App\Models\Agency;
use App\Models\Attachment;
use App\Models\BillMultipleParty;
use App\Models\Form;
use App\Models\FormType;
use App\Models\Hoa;
use App\Models\IfscCode;
use App\Models\ScrutinyAnswers;
use App\Models\ScrutinyItem;
use App\Models\Transaction;
use DB;
use Illuminate\Http\Request;

class IfmisController extends Controller
{
    public function getIfscCodeDetails(getIfscCodeDetailsRequest $request)
    {
        $ifsc_code = $request->get('ifsc_code');
        $details = IfscCode::where('ifsc_code', $ifsc_code)->first();
        if (!$details) {
            return response()->json([
                "status" => false,
                "message" => 'IFSC Details Not Found',
            ]);
        }
        return response()->json([
            "status" => true,
            "data" => $details,
        ]);
    }
    public function addAgency(AddAgencyRequest $request)
    {
        if ($request->get('verified') == false) {
            return response()->json(['status' => false, "message" => "Please Verify Ifsc Code Before Submitting"]);
        }
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
        if ($request->get('verified') == false && $request->get('ifsc_code') != '') {
            if (!IfscCode::where('ifsc_code', $request->ifsc_code)->exists()) {
                return response()->json(['status' => false, "message" => "Enter Valid IFSC Code"]);
            }
            return response()->json(['status' => false, "message" => "Please Verify Ifsc Code Before Submitting"]);
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
        if (count($FormTypes) == 0) {
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
    public function getHoaScrutinyItems(Request $request)
    {
        $form_type_id = $request->get('form_type_id');
        $data = FormType::
            where('id', $form_type_id)
            ->with('formHoaTypeMapping:hoa,hoa_tier')
            ->with(
                'scrutinyItems'
            )
            ->get()->toArray();
        return response()->json([
            "status" => true,
            "message" => "data retrieved",
            "data" => $data
        ]);
    }

    public function submitBill(SubmitBillRequest $request)
    {
        DB::beginTransaction();
        try {

            $bill_multiple_parties = json_decode($request->get('agency_bill'));
            $gross = collect($bill_multiple_parties)->sum('agency_gross');
            $pt_deduction = collect($bill_multiple_parties)->sum('agency_pt_deduction');
            $tds = collect($bill_multiple_parties)->sum('agency_tdsIt');
            $gst = collect($bill_multiple_parties)->sum('agency_gst');
            $gis = collect($bill_multiple_parties)->sum('agency_gis');
            $telangana_haritha_nidhi = collect($bill_multiple_parties)->sum('agency_telangana_haritha_nidhi');
            $net_amount = collect($bill_multiple_parties)->sum('agency_net_amount');

            $transaction = new Transaction();
            $transaction->form_number = $request->get('form_number');
            $transaction->form_type = $request->get('form_type');
            $transaction->hoa = $request->get('hoa');
            $transaction->reference_number = $request->get("reference_number");
            $transaction->purpose = $request->get("purpose");
            $transaction->gross = $gross;
            $transaction->pt_deduction = $pt_deduction;
            $transaction->tds = $tds;
            $transaction->gst = $gst;
            $transaction->gis = $gis;
            $transaction->telangana_haritha_nidhi = $telangana_haritha_nidhi;
            $transaction->net_amount = $net_amount;
            $transaction->save();

            $scrutiny_answers = json_decode($request->get('scrutiny_answers'));
            $scrutiny = [];
            foreach ($scrutiny_answers as $scrutinyAnswer) {
                $scrutiny[] = [
                    'transaction_id' => $transaction->id,
                    'description' => $scrutinyAnswer->description,
                    'answer' => $scrutinyAnswer->answer
                ];
            }
            ScrutinyAnswers::insert($scrutiny);
            $party = [];
            foreach ($bill_multiple_parties as $bill_multiple_party) {
                $party[] = [
                    'transaction_id' => $transaction->id,
                    'agency_name' => $bill_multiple_party->agency_name,
                    'agency_account_number' => $bill_multiple_party->agency_account_number,
                    'ifsc_code' => $bill_multiple_party->agency_ifsc_code,
                    'gross' => $bill_multiple_party->agency_gross,
                    'pt_deduction' => $bill_multiple_party->agency_pt_deduction,
                    'tds' => $bill_multiple_party->agency_tdsIt,
                    'gst' => $bill_multiple_party->agency_gst,
                    'gis' => $bill_multiple_party->agency_gis,
                    'telangana_haritha_nidhi' => $bill_multiple_party->agency_telangana_haritha_nidhi,
                    'net_amount' => $bill_multiple_party->agency_net_amount,
                    'agency_bank_name' => $bill_multiple_party->agency_bank_name,
                    'agency_branch' => $bill_multiple_party->agency_branch
                ];
            }
            BillMultipleParty::insert($party);
            $files = $request->file('files');
            if ($files != null) {
                $attachments = json_decode($request->get('attachments_array'));
                foreach ($files as $index => $file) {
                    $path = $file->store('files');
                    $attachment = new Attachment();
                    $attachment->transaction_id = $transaction->id;
                    $attachment->file_path = $path;
                    $attachment->remarks = $attachments[$index]->remarks;
                    $attachment->save();
                }
            }
            DB::commit();
            return response()->json(['status' => true, "message" => "Bill Added Successfully", "data" => $transaction->id]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                "message" => 'Bill Submission Failed',
                'data' => $e
            ]);
        }
    }
    public function getTransactionDetails(Request $request)
    {
        $id = $request->get('id');
        $transaction = Transaction::
            with([
                'formType' => function ($q) {
                    $q->with('formNumber');
                }
            ])
            ->with('hoa')
            ->with([
                'multipleParties' => function ($q) {
                    $q->with('ifscCode:ifsc_code,bank_name,state,branch');
                }
            ])

            ->where('id', $id)
            ->get()->toArray();
        if (!$transaction) {
            return response()->json(['status' => false, "message" => "Bill Not Found"]);
        }
        // $bill_multiple_parties = Transaction::where('id', $id)->first()->multipleParties;
        return response()->json([
            'status' => true,
            "message" => "Bill Details",
            'data' => $transaction
        ]);
    }

}