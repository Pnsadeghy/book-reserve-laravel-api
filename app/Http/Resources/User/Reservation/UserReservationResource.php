<?php

namespace App\Http\Resources\User\Reservation;

use App\Http\Resources\Relation\BookCopyRelationResource;
use App\Http\Resources\Relation\BookRelationResource;
use App\Http\Resources\Relation\BranchRelationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserReservationResource extends JsonResource
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
            'branch' => new BranchRelationResource($this->branch),
            'book' => new BookRelationResource($this->bookCopy->book),
            'copy' => new BookCopyRelationResource($this->bookCopy),
            'days_reserved' => $this->days_reserved,
            'status' => $this->status,
            'started_at' => $this->started_at,
            'finished_at' => $this->finished_at,
            'expiration_date' => $this->expiration_date,
            'created_at' => $this->created_at,
        ];
    }
}
