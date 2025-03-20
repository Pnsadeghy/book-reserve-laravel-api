<?php

namespace App\Http\Requests\Admin\BookCopy;

use App\Enums\BookCopyConditionEnum;
use App\Enums\BookCopyStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminBookCopyStoreRequest extends FormRequest
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
                'required', 'string',
                Rule::unique('book_copies', 'title')->where('book_id', $id),
            ],
            'visible' => 'required|boolean',
            'special' => 'required|boolean',
            'branch_id' => 'required|uuid|exists:branches,id',
            'status' => ['required', Rule::in(BookCopyStatusEnum::availableValues())],
            'condition' => ['required', Rule::in(BookCopyConditionEnum::values())],
        ];
    }
}
