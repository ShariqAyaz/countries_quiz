<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnswerValidationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'country' => 'required|string|min:1',
            'capital' => 'required|string|min:1',
        ];
    }

    public function message(): array
    {
        return [
            'country.required' => 'Country Require',
            'country.string' => 'Country should be String',
            'capital.required' => 'Capital Require',
            'capital.string' => 'Capital should be String',
        ];
    }
}
