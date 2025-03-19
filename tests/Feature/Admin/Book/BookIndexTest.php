<?php

namespace Tests\Feature\Admin\Book;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookIndexTest extends TestCase
{
    use RefreshDatabase;

    private string $url = '/api/admin/books';

    public function test_index_without_parameters(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Book::factory(5)->create();
        Book::factory(5)->unvisible()->create();

        $response = $this->getJson($this->url);

        $response->assertStatus(200);

        $response->assertJsonCount(5, 'data');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'description',
                    'visible',
                    'created_at',
                ],
            ],
        ]);
    }

    public function test_index_with_q_parameter(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Book::factory()->create([
            'title' => 'test123 World',
        ]);
        Book::factory()->create([
            'description' => 'This is test123 description',
        ]);
        Book::factory(10)->create();

        $response = $this->getJson($this->url.'?q=test123');

        $response->assertStatus(200);

        $response->assertJsonCount(2, 'data');
    }
}
