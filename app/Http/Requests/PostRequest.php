<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

/**
 * Class PostRequest
 * @package App\Http\Requests
 */
class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->getMethod()) {
            case 'POST':
                return [
                    'title' => 'required|string|min:3',
                    'description' => 'string',
                    'tags' => 'array',
					'tags.*' => 'string'
                ];
            case 'DELETE':
                return [
                    'id' => 'required|integer'
                ];
        }
    }


    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     */
    protected function failedValidation($validator)
    {
        $errors = (new ValidationException($validator))->errors();
        $response = [
            'success' => false,
            'message' => $errors,
            'code' => 500
        ];

        throw new HttpResponseException(response()->json($response, JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
