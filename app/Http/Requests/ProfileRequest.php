<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:admins,email,' .$this->id,
            'password'  => 'nullable|confirmed|min:8'

        ];
    }
    public function messages()
    {
        return [
            'name.required' =>'  يجب إدخال الاسم',
            'email.required' =>'يجب إدخال البريد الإلكتروني',
            'email.email' =>' صيغة االبريد الإلكتروني غير صحيحة',
            'email.unique' =>' هذا االبريد الإلكتروني مستخدم ',
            'password.min' =>' كلمة المرور يجب ألا تقل عن ٨ خانات ',
            'password.confirmed' =>' يجب عليك تأكيد كلمة المرور',

        ];
    }
}
