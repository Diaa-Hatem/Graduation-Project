<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use function App\Helpers\SendRespones;


class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(validator $validator)
    {
        if ($this->is('api/*')) {
            $resonse = SendResponse(422, __('keywords.Validation Error'), $validator->errors());
            throw new ValidationException($validator, $resonse);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|string|max:255',
            'password' => 'required'
        ];
    }
    // public function attributes() {
    //     return[
    //         'email'=>'',
    //         'password'=>'',
    //     ];
    // }
}
