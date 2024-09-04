<?php

namespace App\Http\Requests;

use App\Domain\User\Enum\UfEnum;
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
                'max:100',
            ],
            'last_name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                Rule::unique(User::class, 'email'),
            ],
            'document' => [
                'required',
                'string',
                'max:11',
                Rule::unique(User::class, 'document'),
            ],
            'birth_date' => [
                'required',
                'date_format:Y-m-d',
            ],
            'phone_number' => [
                'required',
                'string',
                'max:11',
            ],
            'zip_code' => [
                'required',
                'string',
                'max:7',
            ],
            'uf' => [
                'required',
                'string',
                Rule::enum(UfEnum::class),
            ],
            'city' => [
                'required',
                'string',
                'max:100',
            ],
            'neighborhood' => [
                'required',
                'string',
                'max:100',
            ],
            'address' => [
                'required',
                'string',
                'max:255',
            ]
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(
            [
                'zip_code' => preg_replace('/\D+/', '', $this->get('zip_code', '')),
                'phone_number' => preg_replace('/\D+/', '', $this->get('zip_code', '')),
                'uf' => strtolower($this->get('uf', '')),
            ]
        );
    }
}
