<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'max:255',
                'unique:books,title'
            ],
            'price' => [
                'required',
                'decimal: 0,2',
            ]
        ];
    }
}
