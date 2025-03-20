<?php

namespace Admin\Branch;

use App\Models\Branch;
use App\Utils\Tests\TestUtils;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BranchUpdateTest extends TestCase
{
    use RefreshDatabase, TestUtils;

    private function getUrl(string $id): string
    {
        return '/api/admin/branches/'.$id;
    }

    public function test_update_successfully()
    {
        $this->loginAsAdmin();

        $branch = Branch::factory()->create();

        $response = $this->putJson($this->getUrl($branch->id), [
            'title' => 'Test Branch',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('branches', [
            'title' => 'Test Branch',
            'address' => $branch->address,
            'is_visible' => $branch->is_visible,
        ]);

        $response = $this->putJson($this->getUrl($branch->id), [
            'visible' => false,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('branches', [
            'id' => $branch->id,
            'title' => 'Test Branch',
            'address' => $branch->address,
            'is_visible' => false,
        ]);

        $response = $this->putJson($this->getUrl($branch->id), [
            'address' => 'Test address',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('branches', [
            'id' => $branch->id,
            'title' => 'Test Branch',
            'address' => 'Test address',
            'is_visible' => false,
        ]);

        $response = $this->putJson($this->getUrl($branch->id), [
            'id' => $branch->id,
            'title' => 'Test Branch 2',
            'address' => 'Test Address 2',
            'visible' => true,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('branches', [
            'id' => $branch->id,
            'title' => 'Test Branch 2',
            'address' => 'Test Address 2',
            'is_visible' => true,
        ]);
    }
}
