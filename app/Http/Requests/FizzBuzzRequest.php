<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class FizzBuzzRequest extends FormRequest
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
            'int1'  => ['required','integer','different:int2','min:1','max:5000','lte:limit'],
            'int2'  => ['required','integer','min:1','max:5000','lte:limit'],
            'limit' => ['required','integer','min:1','max:5000'],
            'str1'  => ['required','string','max:15'],
            'str2'  => ['required','string','max:15'],
        ];
    }

    public function messages(): array
    {
        return [
            'int1.different' => 'int1 and int2 must be different to avoid ambiguity.',
            'int1.lte' => 'int1 must be less than or equal to limit.',
            'int2.lte' => 'int2 must be less than or equal to limit.',
        ];
    }

    /**
     * @param Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'The given data was invalid.',
                'errors'  => $validator->errors(),
            ], 400)
        );
    }
}
