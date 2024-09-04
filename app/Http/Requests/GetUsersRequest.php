<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

class GetUsersRequest extends FormRequest
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
            'page_size' => 'integer',
            'page' => 'integer|min:1'
        ];
    }

    public function attributes()
    {
        return Lang::get(
            'user.get.attributes'
        );
    }

    public function messages()
    {
        return Lang::get(
            'user.get.messages'
        );
    }

    protected function prepareForValidation()
    {
        $this->merge(
            [
                'page' => filter_var($this->query('page', 1), FILTER_VALIDATE_INT),
                'page_size' => filter_var($this->query('page_size', 20), FILTER_VALIDATE_INT)
            ]
        );
    }
}
