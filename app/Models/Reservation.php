<?php

namespace App\Models;

use App\Enums\ReservationStatusEnum;
use App\Observers\ReservationObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

#[ObservedBy([ReservationObserver::class])]
class Reservation extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'branch_id',
        'book_copy_id',
        'days_reserved',
        'status',
        'started_at',
        'finished_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
        'expiration_date' => 'datetime',
    ];

    // region attributes
    protected function isFinished(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => in_array($attributes['status'], ReservationStatusEnum::finishValues()),
        );
    }
    // endregion

    // region Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): HasOneThrough
    {
        return $this->hasOneThrough(Book::class, BookCopy::class);
    }

    public function bookCopy(): BelongsTo
    {
        return $this->belongsTo(BookCopy::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
    // endregion
}
