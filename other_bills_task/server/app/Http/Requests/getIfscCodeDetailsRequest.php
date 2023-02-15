<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class getIfscCodeDetailsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'ifsc_code'=>'required|regex:/^[A-Z]{4}0[A-Z0-9]{6}$/'
        ];
    }
    public function messages()
    {
        return [
            'ifsc_code.regex'=>'Enter Valid IFSC Code'
        ];
    }
}
