<?php

namespace App\Http\Requests\User\Reservation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserReservationStoreRequest extends FormRequest
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
        // TODO we can have some logics for max days base on user type or user behaviour
        return [
            'book_copy_id' => 'required|uuid',
            'days' => 'required|numeric|min:1',
        ];
    }
}
