<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:30',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'nullable|regex:/^\d{10,11}$/',
            'address'      => 'nullable|string|max:255',
            'password' => 'required|min:7|max:50|regex:/^[a-zA-Z0-9]+$/',
        ];
    }

    public function messages()
    {
        return [
            'name.required'  => 'メイは必ず入力してください。',
            'name.max'       => 'メイは30文字以内で入力してください。',
            'email.required'            => 'メールアドレスは必ず入力してください。',
            'email.email'               => 'ご入力いただいたメールアドレスは正しいメールアドレス形式ではありません。',
            'email.unique'              => 'このメールアドレスはすでに使用されています。',
            'phone_number.regex'        => '電話番号は10桁または11桁の半角数字で入力してください。',
            'address.string'            => '住所は文字列で入力してください。',
            'address.max'               => '住所は255文字以内で入力してください。',
            'password.required'         => 'パスワードは必ず入力してください。',
            'password.min'              => 'パスワードは7~50文字で入力してください。',
            'password.max'              => 'パスワードは7~50文字で入力してください。',
            'password.regex'            => '半角英数字で入力してください。'
        ];
    }
}
