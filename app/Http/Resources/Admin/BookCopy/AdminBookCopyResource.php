<?php

namespace App\Http\Resources\Admin\BookCopy;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminBookCopyResource extends JsonResource
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
            'branch_id' => $this->branch_id,
            'title' => $this->title,
            'visible' => $this->is_visible,
            'status' => $this->status,
            'condition' => $this->condition,
            'special' => $this->is_special,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
