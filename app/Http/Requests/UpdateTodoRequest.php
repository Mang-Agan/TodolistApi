<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateTodoRequest extends FormRequest
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
            'todo' => 'required|string|max:255',
            'id' => 'required|exists:todolists,id'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response([
            'status' => false,
            'message' => 'Error Validation',
            'errors' => $validator->getMessageBag(),
            'params' => null
        ], 400));
    }
}
