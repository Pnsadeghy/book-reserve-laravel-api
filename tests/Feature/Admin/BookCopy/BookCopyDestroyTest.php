<?php

namespace Admin\BookCopy;

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Branch;
use App\Models\Reservation;
use App\Models\User;
use App\Utils\Tests\TestUtils;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookCopyDestroyTest extends TestCase
{
    use RefreshDatabase, TestUtils;

    private function getUrl(string $id): string
    {
        return '/api/admin/bookCopies/'.$id;
    }

    public function test_destroy_successfully()
    {
        $this->loginAsAdmin();

        $copy = BookCopy::factory()->create([
            'book_id' => Book::factory()->create()->id,
            'branch_id' => Branch::factory()->create()->id,
        ]);

        $response = $this->delete($this->getUrl($copy->id));

        $response->assertStatus(204);

        $this->assertDatabaseMissing('book_copies', [
            'id' => $copy->id,
        ]);
    }

    public function test_destroy_failed_when_have_reservation()
    {
        $this->loginAsAdmin();

        $copy = BookCopy::factory()->create([
            'book_id' => Book::factory()->create(),
            'branch_id' => Branch::factory()->create()->id,
        ]);
        Reservation::factory()->create([
            'user_id' => User::factory()->create()->id,
            'book_copy_id' => $copy->id,
            'branch_id' => $copy->branch_id,
        ]);

        $response = $this->delete($this->getUrl($copy->id));

        $response->assertStatus(403);
    }

    // TODO Write test: can have effect on book is_available column
}
