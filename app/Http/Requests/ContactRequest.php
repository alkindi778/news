<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:1000'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'الرجاء إدخال الاسم',
            'name.max' => 'الاسم يجب أن لا يتجاوز 255 حرف',
            'email.required' => 'الرجاء إدخال البريد الإلكتروني',
            'email.email' => 'الرجاء إدخال بريد إلكتروني صحيح',
            'email.max' => 'البريد الإلكتروني يجب أن لا يتجاوز 255 حرف',
            'subject.required' => 'الرجاء إدخال الموضوع',
            'subject.max' => 'الموضوع يجب أن لا يتجاوز 255 حرف',
            'message.required' => 'الرجاء إدخال الرسالة',
            'message.max' => 'الرسالة يجب أن لا تتجاوز 1000 حرف',
        ];
    }
}
