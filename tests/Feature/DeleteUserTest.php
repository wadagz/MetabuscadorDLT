<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DeleteUserTest extends TestCase
{
    use DatabaseTransactions;

    public function test_can_delete_account(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user)->delete(
            route('deleteUser')
        );
        $this->assertNull($user->fresh());
        $this->assertModelMissing($user);
    }

}
