<?php

namespace Tests\Unit\Services;

use App\Enums\BookCopyStatusEnum;
use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Branch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookAvailabilityServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_book_availability_with_available_copy()
    {
        $book = Book::factory()->create();

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'is_available' => false,
        ]);

        $copy = BookCopy::factory()->create([
            'is_visible' => true,
            'book_id' => $book->id,
            'branch_id' => Branch::factory()->create()->id,
            'status' => BookCopyStatusEnum::Available,
        ]);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'is_available' => true,
        ]);
    }

    public function test_book_availability_with_unavailable_copy()
    {
        $book = Book::factory()->create();

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'is_available' => false,
        ]);

        $copy = BookCopy::factory()->create([
            'is_visible' => true,
            'book_id' => $book->id,
            'branch_id' => Branch::factory()->create()->id,
            'status' => BookCopyStatusEnum::UnderRepair,
        ]);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'is_available' => false,
        ]);

        $copy->status = BookCopyStatusEnum::Available;
        $copy->save();

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'is_available' => true,
        ]);
    }

    public function test_book_availability_with_invisible_copy()
    {
        $book = Book::factory()->create();

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'is_available' => false,
        ]);

        $copy = BookCopy::factory()->create([
            'is_visible' => false,
            'book_id' => $book->id,
            'branch_id' => Branch::factory()->create()->id,
            'status' => BookCopyStatusEnum::Available,
        ]);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'is_available' => false,
        ]);

        $copy->is_visible = true;
        $copy->save();

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'is_available' => true,
        ]);
    }
}
