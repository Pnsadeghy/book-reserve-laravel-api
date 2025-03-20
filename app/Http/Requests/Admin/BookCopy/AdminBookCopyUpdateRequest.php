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
        $id = $this->route('bookCopy')->id ?? null;
        $book_id = $this->route('bookCopy')->book_id ?? null;

        return [
            'title' => [
                'required', 'string',
                Rule::unique('book_copies', 'title')->ignore($id)->where('book_id', $book_id),
            ],
            'visible' => 'required|boolean',
            'branch_id' => 'required|uuid|exists:branches,id',
            'status' => ['required', Rule::in(BookCopyStatusEnum::availableValues())],
            'condition' => ['required', Rule::in(BookCopyConditionEnum::values())],
        ];
    }
}
