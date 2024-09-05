<?php

namespace App\Http\Requests;

use App\Domain\User\Enum\UfEnum;
use App\Domain\User\Rules\CPF;
use App\Models\User;
use Illuminate\Validation\Rule;

class CreateNewUserRequest extends UserFormRequest
{
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
                new CPF
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
                'max:8',
            ],
            'status' => [
                'required',
                'boolean'
            ]
        ];
    }

    protected function prepareForValidation()
    {
        parent::prepareForValidation();

        $this->merge(
            [
                'status' => $this->getStatus()
            ]
        );
    }
}
