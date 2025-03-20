<?php

namespace App\Http\Requests\Admin\BookCopy;

use App\Enums\BookCopyConditionEnum;
use App\Enums\BookCopyStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminBookCopyUpdateRequest extends FormRequest
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
        $model = $this->route('bookCopy');
        $id = $model->id ?? null;
        $book_id = $model->book_id ?? null;
        $status = $model->status ?? null;

        $rules = [
            'title' => [
                'sometimes', 'string',
                Rule::unique('book_copies', 'title')->ignore($id)->where('book_id', $book_id),
            ],
            'visible' => 'sometimes|boolean',
            'special' => 'sometimes|boolean',
        ];

        if ($status !== BookCopyStatusEnum::Reserved) {
            $rules['status'] = ['sometimes', Rule::in(BookCopyStatusEnum::availableValues())];
            $rules['condition'] = ['sometimes', Rule::in(BookCopyConditionEnum::values())];
            $rules['branch_id'] = 'sometimes|uuid|exists:branches,id';
        }

        return $rules;
    }
}
