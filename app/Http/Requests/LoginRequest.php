<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.required'            => 'メールアドレスは必ず入力してください。',
            'email.email'               => 'ご入力いただいたメールアドレスは正しいメールアドレス形式ではありません。',
            'password.required'         => 'パスワードは必ず入力してください。',
        ];
    }
}
