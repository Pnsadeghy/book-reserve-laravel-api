<?php

namespace App\Http\Resources\User\Book;

use App\Http\Resources\Relation\BranchRelationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserBookCopyShowResource extends JsonResource
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
            'status' => $this->status,
            'branch' => new BranchRelationResource($this->branch),
        ];
    }
}
