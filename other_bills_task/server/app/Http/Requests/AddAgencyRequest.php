<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddAgencyRequest extends FormRequest
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
            'name'=>'required',
            'account_number' => 'required|min:12|max:22',
            'ifsc_code'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'min'=>'Account should be more than 12 characters',
            'account_number.max'=>'Account should be Less than 22 characters',
            // 'account_number.confirmed'=>"Account Number Don't Matched"
        ];
    }
}
