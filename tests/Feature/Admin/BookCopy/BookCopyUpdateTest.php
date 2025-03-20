<?php

namespace Admin\BookCopy;

use App\Enums\BookCopyConditionEnum;
use App\Enums\BookCopyStatusEnum;
use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Branch;
use App\Utils\Tests\TestUtils;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookCopyUpdateTest extends TestCase
{
    use RefreshDatabase, TestUtils;

    private function getUrl(string $id): string
    {
        return '/api/admin/bookCopies/'.$id;
    }

    public function test_update_successfully()
    {
        $this->loginAsAdmin();

        $book = Book::factory()->create();
        $branch = Branch::factory()->create();
        $bookCopy = BookCopy::factory()->create([
            'branch_id' => $branch->id,
            'book_id' => $book->id,
        ]);

        $response = $this->putJson($this->getUrl($bookCopy->id), [
            'title' => 'Test Copy',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('book_copies', [
            'id' => $bookCopy->id,
            'title' => 'Test Copy',
            'is_visible' => $bookCopy->is_visible,
            'status' => $bookCopy->status,
        ]);

        $response = $this->putJson($this->getUrl($bookCopy->id), [
            'title' => 'Test Copy 2',
            'visible' => true,
            'status' => BookCopyStatusEnum::UnderRepair,
            'condition' => BookCopyConditionEnum::Worn,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('book_copies', [
            'id' => $bookCopy->id,
            'title' => 'Test Copy 2',
            'is_visible' => true,
            'status' => BookCopyStatusEnum::UnderRepair,
            'condition' => BookCopyConditionEnum::Worn,
        ]);
    }
}
