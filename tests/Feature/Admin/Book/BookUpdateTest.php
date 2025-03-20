<?php

namespace Admin\Book;

use App\Models\Book;
use App\Utils\Tests\TestUtils;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookUpdateTest extends TestCase
{
    use RefreshDatabase, TestUtils;

    private function getUrl(string $id): string
    {
        return '/api/admin/books/'.$id;
    }

    public function test_update_successfully()
    {
        $this->loginAsAdmin();

        $book = Book::factory()->create();

        $response = $this->putJson($this->getUrl($book->id), [
            'title' => 'Test Book',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => 'Test Book',
            'description' => $book->description,
            'is_visible' => $book->is_visible,
        ]);

        $response = $this->putJson($this->getUrl($book->id), [
            'title' => 'Test Book 2',
            'description' => 'Test description 2',
            'visible' => false,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => 'Test Book 2',
            'description' => 'Test description 2',
            'is_visible' => false,
        ]);
    }
}
