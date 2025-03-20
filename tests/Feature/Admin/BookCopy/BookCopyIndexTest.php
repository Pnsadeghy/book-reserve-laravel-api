<?php

namespace Admin\BookCopy;

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Branch;
use App\Utils\Tests\TestUtils;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookCopyIndexTest extends TestCase
{
    use RefreshDatabase, TestUtils;

    private function getUrl(string $id): string
    {
        return '/api/admin/books/'.$id.'/copies';
    }

    public function test_index(): void
    {
        $this->loginAsAdmin();

        $book_1 = Book::factory()->create();
        $book_2 = Book::factory()->create();
        $branch = Branch::factory()->create();
        BookCopy::factory(5)->create([
            'book_id' => $book_1->id,
            'branch_id' => $branch->id,
            'is_visible' => false,
        ]);
        BookCopy::factory(5)->create([
            'book_id' => $book_1->id,
            'branch_id' => $branch->id,
            'is_visible' => true,
        ]);
        BookCopy::factory(5)->create([
            'book_id' => $book_2->id,
            'branch_id' => $branch->id,
        ]);

        $response = $this->getJson($this->getUrl($book_1->id));

        $response->assertStatus(200);

        $response->assertJsonCount(10);

        $response->assertJsonStructure([
            '*' => [
                'id',
                'title',
                'visible',
                'status',
                'condition',
                'created_at',
                'updated_at',
            ],
        ]);
    }
}
