<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShippingsRequest extends FormRequest
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
            'id' => 'required|exists:settings',
            'value' => 'required',
            'plain_value' => 'nullable|numeric',
        ];
    }
    public function messages()
    {
        return [
            'email.required' =>'يجب إدخال البريد الإلكتروني',
            'email.email' =>' صيغة االبريد الإلكتروني غير صحيحة',
            'password.required' =>' يجب إدخال كلمة المرور',
        ];
    }
}
