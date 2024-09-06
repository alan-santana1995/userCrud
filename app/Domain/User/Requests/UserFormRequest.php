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
        $data = $this->all();

        foreach ($data as &$field) {
            $field = strip_tags(trim($field));
        }

        $data = array_merge(
            $data,
            preg_replace(
                '/\D+/',
                '',
                $this->all(
                    [
                        'document',
                        'zip_code',
                        'phone_number',
                    ]
                )
            )
        );

        $this->merge(
            array_filter($data, fn ($value) => $value !== "" && $value !== null)
        );
    }

    protected function getStatus()
    {
        return filter_var($this->get('status', true), FILTER_VALIDATE_BOOL);
    }
}
