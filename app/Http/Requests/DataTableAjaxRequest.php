<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DataTableAjaxRequest extends FormRequest
{
    public function authorize(): bool{
        return true;
    }
    public function rules(): array{
        return [
            'draw' => ['required','integer'],
            'columns' => ['required','array'],
            'order' => ['required','array'],
            'start' => ['required','integer'],
            'length' => ['required','integer'],
            'search' => ['required','array'],
        ];
    }
}
