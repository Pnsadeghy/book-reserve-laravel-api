<?php

namespace App\Http\Resources\User\Book;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserBookShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'available' => $this->available,
            'copies' => UserBookCopyShowResource::collection($this->copies),
        ];
    }
}
