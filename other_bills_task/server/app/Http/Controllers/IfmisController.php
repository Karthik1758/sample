<?php

namespace App\Http\Controllers;

use App\Http\Requests\getIfmisDetailsRequest;
use App\Http\Requests\getIfscCodeDetailsRequest;
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

}