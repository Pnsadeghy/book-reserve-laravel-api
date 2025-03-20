<?php

namespace App\Http\Resources\Admin\Reservation;

use App\Http\Resources\Relation\BookCopyRelationResource;
use App\Http\Resources\Relation\BookRelationResource;
use App\Http\Resources\Relation\BranchRelationResource;
use App\Http\Resources\Relation\UserRelationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminReservationResource extends JsonResource
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
            'user' => new UserRelationResource($this->user),
            'branch' => new BranchRelationResource($this->branch),
            'book' => new BookRelationResource($this->bookCopy->book),
            'copy' => new BookCopyRelationResource($this->bookCopy),
            'days_reserved' => $this->days_reserved,
            'status' => $this->status,
            'started_at' => $this->started_at,
            'finished_at' => $this->finished_at,
            'expiration_date' => $this->expiration_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
