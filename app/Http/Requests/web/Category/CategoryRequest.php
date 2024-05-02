<?php

namespace App\Http\Requests\Web\Category;

use Illuminate\Foundation\Http\FormRequest;


class CategoryRequest extends FormRequest
{
    public function authorize(): bool{
        return true;
    }
    public function rules(): array{
        return [
            'name' => ['required' , 'string' , 'max:255' , 'unique:categories,name,'.$this->category?->id],
            'status' => ['required'],
        ];
    }
}
