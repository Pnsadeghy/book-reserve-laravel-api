<?php

namespace App\Http\Resources\Admin\Book;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminBookListItemResource extends JsonResource
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
            'visible' => $this->is_visible,
            'available' => $this->is_available,
            'created_at' => $this->created_at,
        ];
    }
}
