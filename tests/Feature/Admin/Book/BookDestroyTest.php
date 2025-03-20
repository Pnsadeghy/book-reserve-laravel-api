<?php

namespace Admin\Book;

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Branch;
use App\Models\Reservation;
use App\Models\User;
use App\Utils\Tests\TestUtils;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookDestroyTest extends TestCase
{
    use RefreshDatabase, TestUtils;

    private function getUrl(string $id): string
    {
        return '/api/admin/books/'.$id;
    }

    public function test_destroy_successfully()
    {
        $this->loginAsAdmin();

        $book = Book::factory()->create();
        BookCopy::factory()->create([
            'book_id' => $book->id,
            'branch_id' => Branch::factory()->create()->id,
        ]);

        $response = $this->delete($this->getUrl($book->id));

        $response->assertStatus(204);

        $this->assertDatabaseMissing('books', [
            'id' => $book->id,
        ]);
        $this->assertDatabaseMissing('book_copies', [
            'book_id' => $book->id,
        ]);
    }

    public function test_destroy_failed_when_have_reservation()
    {
        $this->loginAsAdmin();

        $book = Book::factory()->create();
        $copy = BookCopy::factory()->create([
            'book_id' => $book->id,
            'branch_id' => Branch::factory()->create()->id,
        ]);
        Reservation::factory()->create([
            'user_id' => User::factory()->create()->id,
            'book_copy_id' => $copy->id,
            'branch_id' => $copy->branch_id,
        ]);

        $response = $this->delete($this->getUrl($book->id));

        $response->assertStatus(403);
    }
}
