<?php

namespace Tests\Unit\Services;

use App\Enums\BookCopyStatusEnum;
use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Branch;
use App\Services\BookAvailabilityService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookAvailabilityServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_book_availability_with_available_copy()
    {
        $repo = new BookAvailabilityService;

        $book = Book::factory()->create();

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'is_available' => false,
        ]);

        $copy = BookCopy::factory()->createQuietly([
            'is_visible' => true,
            'book_id' => $book->id,
            'branch_id' => Branch::factory()->create()->id,
            'status' => BookCopyStatusEnum::Available,
        ]);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'is_available' => false,
        ]);

        $repo->checkAvailability($book);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'is_available' => true,
        ]);
    }

    public function test_book_availability_with_unavailable_copy()
    {
        $repo = new BookAvailabilityService;

        $book = Book::factory()->create();

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'is_available' => false,
        ]);

        $copy = BookCopy::factory()->createQuietly([
            'is_visible' => true,
            'book_id' => $book->id,
            'branch_id' => Branch::factory()->create()->id,
            'status' => BookCopyStatusEnum::UnderRepair,
        ]);

        $repo->checkAvailability($book);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'is_available' => false,
        ]);

        $copy->status = BookCopyStatusEnum::Available;
        $copy->saveQuietly();

        $repo->checkAvailability($book);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'is_available' => true,
        ]);
    }

    public function test_book_availability_with_invisible_copy()
    {
        $repo = new BookAvailabilityService;

        $book = Book::factory()->create();

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'is_available' => false,
        ]);

        $copy = BookCopy::factory()->createQuietly([
            'is_visible' => false,
            'book_id' => $book->id,
            'branch_id' => Branch::factory()->create()->id,
            'status' => BookCopyStatusEnum::Available,
        ]);

        $repo->checkAvailability($book);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'is_available' => false,
        ]);

        $copy->is_visible = true;
        $copy->saveQuietly();

        $repo->checkAvailability($book);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'is_available' => true,
        ]);
    }
}
