<?php

namespace Admin\Branch;

use App\Utils\Tests\TestUtils;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BranchStoreTest extends TestCase
{
    use RefreshDatabase, TestUtils;

    private string $url = '/api/admin/branches';

    public function test_store_successfully()
    {
        $this->loginAsAdmin();

        $response = $this->postJson($this->url, [
            'title' => 'Test Branch',
            'address' => 'This is a test branch address.',
            'visible' => true,
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'title',
                'address',
                'visible',
                'created_at',
            ])
            ->assertJsonFragment([
                'title' => 'Test Branch',
                'address' => 'This is a test branch address.',
                'visible' => true,
            ]);

        $this->assertDatabaseHas('branches', [
            'title' => 'Test Branch',
            'address' => 'This is a test branch address.',
            'is_visible' => true,
        ]);
    }
}
