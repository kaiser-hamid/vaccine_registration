<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:vaccine_registrations',
            'nid' => 'required|numeric|unique:vaccine_registrations',
            'vaccine_center_id' => 'required|numeric',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        return response([
            'message' => $validator->errors()->first(),
            'data' => null,
            'errors' => $validator->errors()
        ], 422);
    }
}
