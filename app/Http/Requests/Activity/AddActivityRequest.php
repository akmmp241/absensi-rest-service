<?php

namespace App\Http\Requests\Activity;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class AddActivityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->role_id === User::$STUDENT;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "student_id" => ["required", "numeric", Rule::exists('students', 'id')],
            "dudi_id" => ["required", "numeric", Rule::exists('dudis', 'id')],
            "type" => ["required", "string", Rule::in(["masuk", "keluar"])],
            "detail" => ["required", "string"],
            "date" => ["required"],
            "image" => ["required", "image", "max:1024"],
        ];
    }

    public function messages(): array
    {
        return [
            "type.in" => "Type must be masuk or keluar",
            "image.max" => "Image size must be less than 1MB"
        ];
    }

    protected function failedAuthorization()
    {
        throw new HttpResponseException(response()->json([
            "data" => [
                "success" => false,
                "message" => "This action can only done by student"
            ]
        ], Response::HTTP_UNAUTHORIZED));
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            "errors" => $validator->errors()
        ], Response::HTTP_BAD_REQUEST));
    }
}
