<?php

namespace App\Utils\Tests;

use App\Models\User;

trait TestUtils
{
    private function loginAsAdmin()
    {
        $user = User::factory()->create([
            'is_admin' => true,
        ]);
        $this->actingAs($user);
    }
}
