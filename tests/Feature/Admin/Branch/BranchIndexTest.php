<?php

namespace Tests\Feature\Admin\Branch;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BranchIndexTest extends TestCase
{
    use RefreshDatabase;

    private string $url = '/api/admin/branches';

    public function test_index_without_parameters(): void
    {
        $user = User::factory()->create([
            'is_admin' => true
        ]);
        $this->actingAs($user);

        Branch::factory(5)->create();
        Branch::factory(5)->create([
            'is_visible' => true,
        ]);

        $response = $this->getJson($this->url);

        $response->assertStatus(200);

        $response->assertJsonCount(10, 'data');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'address',
                    'visible',
                    'created_at',
                ],
            ],
        ]);
    }

    public function test_index_with_q_parameter(): void
    {
        $user = User::factory()->create([
            'is_admin' => true
        ]);
        $this->actingAs($user);

        Branch::factory()->create([
            'title' => 'test123 World',
        ]);
        Branch::factory()->create([
            'address' => 'This is test123 address',
        ]);
        Branch::factory(10)->create();

        $response = $this->getJson($this->url.'?q=test123');

        $response->assertStatus(200);

        $response->assertJsonCount(2, 'data');
    }
}
