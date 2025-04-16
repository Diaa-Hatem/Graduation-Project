<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;
use function App\Helpers\SendRespones;

use function Laravel\Prompts\password;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        if ($this->is('api/*')) {
            $resonse = SendResponse(422, __('keywords.Validation Error'), $validator->errors()->all());
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:Users',
            'password' => ['required', 'confirmed', password::default()]
        ];
    }
    // public function attributes() {
    //     return[
    //         'name'=>'',
    //         'email'=>'',
    //         'password'=>'',
    //     ];
    // }
}
