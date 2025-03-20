<?php

namespace Admin\Book;

use App\Utils\Tests\TestUtils;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookStoreTest extends TestCase
{
    use RefreshDatabase, TestUtils;

    private string $url = '/api/admin/books';

    public function test_store_successfully()
    {
        $this->loginAsAdmin();

        $response = $this->postJson($this->url, [
            'title' => 'Test Book',
            'description' => 'This is a test book.',
            'visible' => true,
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'title',
                'description',
                'visible',
                'available',
                'created_at',
            ])
            ->assertJsonFragment([
                'title' => 'Test Book',
                'description' => 'This is a test book.',
                'visible' => true,
                'available' => false,
            ]);

        $this->assertDatabaseHas('books', [
            'title' => 'Test Book',
            'description' => 'This is a test book.',
            'is_visible' => true,
        ]);
    }
}
