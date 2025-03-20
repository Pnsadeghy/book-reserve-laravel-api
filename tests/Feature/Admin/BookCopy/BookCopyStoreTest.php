<?php

namespace Admin\BookCopy;

use App\Enums\BookCopyConditionEnum;
use App\Enums\BookCopyStatusEnum;
use App\Models\Book;
use App\Models\Branch;
use App\Utils\Tests\TestUtils;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookCopyStoreTest extends TestCase
{
    use RefreshDatabase, TestUtils;

    private function getUrl(string $id): string
    {
        return '/api/admin/books/'.$id.'/copies';
    }

    public function test_store_successfully()
    {
        $this->loginAsAdmin();

        $book = Book::factory()->create();
        $branch = Branch::factory()->create();

        $response = $this->postJson($this->getUrl($book->id), [
            'title' => 'Test Copy',
            'visible' => true,
            'branch_id' => $branch->id,
            'status' => BookCopyStatusEnum::Available,
            'condition' => BookCopyConditionEnum::Good,
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'branch_id',
                'title',
                'status',
                'condition',
                'visible',
                'created_at',
                'updated_at',
            ])
            ->assertJsonFragment([
                'title' => 'Test Copy',
                'visible' => true,
                'branch_id' => $branch->id,
                'status' => BookCopyStatusEnum::Available,
                'condition' => BookCopyConditionEnum::Good,
            ]);

        $this->assertDatabaseHas('book_copies', [
            'title' => 'Test Copy',
            'is_visible' => true,
            'branch_id' => $branch->id,
            'status' => BookCopyStatusEnum::Available,
            'condition' => BookCopyConditionEnum::Good,
        ]);
    }
}
