<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddLeave extends FormRequest
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
            'employee_id'=>'required',
            'from'=>'required|date|after:today',
            'to'=>'required|date|after:from',
            'type'=>'required',
            'reason'=>'required',   
        ];
    }
    public function messages()
    {
        return [
            'from.date'=>'Select Valid Date',
            'to.date'=>'Select Valid Date',
            'from.after'=>'Select Valid Date',
            'to.after'=>'Select Valid Date',
        ];
    }
}
