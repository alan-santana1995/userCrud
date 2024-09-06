<?php

namespace App\Domain\User\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

class UserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function messages()
    {
        return Lang::get('user.user_form.messages');
    }

    protected function prepareForValidation()
    {
        $data = [
            preg_replace(
                '/\D+/',
                '',
                [
                    'document' => $this->get('document', ''),
                    'zip_code' => $this->get('zip_code', ''),
                    'phone_number' => $this->get('phone_number', ''),
                ]
            )
        ];

        $data['uf'] = strtolower($this->get('uf', ''));

        $this->merge($data);
    }

    protected function getStatus()
    {
        return filter_var($this->get('status', true), FILTER_VALIDATE_BOOL);
    }
}
