<?php

namespace App\Domain\User\Requests;

use App\Domain\User\Rules\CPF;
use App\Domain\User\Models\User;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends UserFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => [
                'bail',
                'required',
                'integer',
                Rule::exists(User::class, 'id')
            ],
            'name' => [
                'string',
                'max:100',
            ],
            'email' => [
                'email',
            ],
            'document' => [
                'string',
                'max:11',
                new CPF
            ],
            'birth_date' => [
                'date_format:Y-m-d',
            ],
            'phone_number' => [
                'string',
                'max:10',
            ],
            'zip_code' => [
                'string',
                'max:8',
            ],
            'status' => [
                'boolean'
            ],
        ];
    }

    protected function prepareForValidation()
    {
        parent::prepareForValidation();

        $data = [
            'id' => $this->route('user')
        ];

        if ($this->has('status')) {
            $data['status'] = $this->getStatus();
        }

        $this->merge($data);
    }
}
