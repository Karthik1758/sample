<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddEmployee extends FormRequest
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
            'full_name'=>'required|max:20',
            'dob'=>'required|date',
            'phone_number'=>'required|digits:10',
            'email'=>'required|email',
            'gender'=>'required',
            'password'=>'required|confirmed',
        ];
    }
    public function messages()
    {
        return [
            'full_name.max'=>'Full Name should be less than 20 characters',
            'email.email' => "Enter Valid Email",
            'phone_number.digits' => "Phone Number Should be 10 Digits",
            'dob.date'=>'Select Valid Date',
            'password.confirmed'=>'Password and Confirm Password Should be Same'
        ];
    }
}
