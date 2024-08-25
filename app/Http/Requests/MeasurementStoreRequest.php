<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MeasurementStoreRequest extends FormRequest
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
            'sys' => ['required', 'numeric'],
            'dia' => ['required', 'numeric'],
            'pulse' => ['required', 'numeric'],
            'note' => ['nullable'],
            'date' => ['required', 'date', 'before_or_equal:' . date('d.m.Y')],
            'time' => ['required', 'date_format:H:i'],
        ];
    }
}
