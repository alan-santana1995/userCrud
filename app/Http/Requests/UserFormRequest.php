<?php

namespace App\Http\Requests;

use App\Http\Domain\User\Enum\UfEnum;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserFormRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'min:10',
                'max:255'
            ],
            'email' => [
                'required',
                'email',
                Rule::unique(User::class, 'email')
            ],
            'document' => [
                'required',
                'email',
                Rule::unique(User::class, 'document')
            ],
            'birth_date' => [
                'required',
                'string',
                'date'
            ],
            'phone_number' => [
                'required',
                'string',
                'max: 15'
            ],
            'zip_code' => [
                'required',
                'string',
                'max:10'
            ],
            'uf' => [
                'required',
                'string',
                Rule::enum(UfEnum::class)
            ],
            'city' => [
                'required',
                'string',
                'max:100'
            ],
            'neighborhood' => [
                'required',
                'string',
                'max:100'
            ],
            'address' => [
                'required',
                'string',
                'max:255'
            ]
        ];
    }
}
