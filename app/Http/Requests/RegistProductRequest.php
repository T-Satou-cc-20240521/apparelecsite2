<?php

namespace App\Http\Requests;

use App\Rules\CheckCategoryIdRule;
use Illuminate\Foundation\Http\FormRequest;

class RegistProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'category_id' => ['required', 'integer', new CheckCategoryIdRule('存在しないカテゴリです。')],
            'price' => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名は必ず入力してください。',
            'name.max' => '商品名は255文字以内で入力してください。',
            'description.max' => '説明は255文字以内で入力してください。',
            'category_id.required' => 'カテゴリIDは必ず入力してください。',
            'price.required' => '価格は必ず入力してください。',
            'price.integer' => '価格は整数で入力してください。',
            'price.min' => '価格は1円以上で指定してください。',
        ];
    }
}
