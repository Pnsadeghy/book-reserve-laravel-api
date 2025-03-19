<?php

namespace App\Http\Requests\Admin\Book;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminBookUpdateRequest extends FormRequest
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
        $id = $this->route('book')->id ?? null;

        return [
            'title' => [
                'sometimes', 'string',
                Rule::unique('books', 'title')->ignore($id),
            ],
            'description' => 'sometimes|nullable|string',
            'visible' => 'sometimes|boolean',
        ];
    }
}
