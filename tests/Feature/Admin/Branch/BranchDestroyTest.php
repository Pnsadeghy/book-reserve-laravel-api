<?php

namespace Admin\Branch;

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Branch;
use App\Models\Reservation;
use App\Models\User;
use App\Utils\Tests\TestUtils;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BranchDestroyTest extends TestCase
{
    use RefreshDatabase, TestUtils;

    private function getUrl(string $id): string
    {
        return '/api/admin/branches/'.$id;
    }

    public function test_destroy_successfully()
    {
        $this->loginAsAdmin();

        $branch = Branch::factory()->create();

        $response = $this->delete($this->getUrl($branch->id));

        $response->assertStatus(204);

        $this->assertDatabaseMissing('branches', [
            'id' => $branch->id,
        ]);
    }

    public function test_destroy_failed_when_have_copies()
    {
        $this->loginAsAdmin();

        $branch = Branch::factory()->create();
        BookCopy::factory()->create([
            'book_id' => Book::factory()->create()->id,
            'branch_id' => $branch->id,
        ]);

        $response = $this->delete($this->getUrl($branch->id));

        $response->assertStatus(403);
    }

    public function test_destroy_failed_when_have_reservation()
    {
        $this->loginAsAdmin();

        $branch = Branch::factory()->create();
        Reservation::factory()->create([
            'user_id' => User::factory()->create()->id,
            'book_copy_id' => BookCopy::factory()->create([
                'book_id' => Book::factory()->create()->id,
                'branch_id' => $branch->id,
            ])->id,
            'branch_id' => $branch->id,
        ]);

        $response = $this->delete($this->getUrl($branch->id));

        $response->assertStatus(403);
    }
}
