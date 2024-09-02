<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UniqueDocumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'document' => [
                'required',
                'string',
                Rule::unique(User::class, 'document')
            ]
        ];
    }

    protected function prepareForValidation()
    {
        $document = $this->get('document', '');

        $this->merge(
            [
                'document' => preg_replace('/\D+/', '', $document)
            ]
        );
    }
}
