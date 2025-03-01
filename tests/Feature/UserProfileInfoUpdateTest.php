<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;
use Tests\TestCase;

class UserProfileInfoUpdateTest extends TestCase
{
    use DatabaseTransactions;

    public function test_can_update_name(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->put(
            'user/profile-information',
            [
                'nombre' => 'Antonio Bragueta',
                'correo' => $user->email,
            ]
        );
        $response->assertSessionHasNoErrors();
        $this->assertEquals('Antonio Bragueta', $user->fresh()->name);
    }

    public function test_can_update_email(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->put(
            'user/profile-information',
            [
                'nombre' => $user->name,
                'correo' => 'superemaildeprueba433@gmail.com',
            ]
        );
        $response->assertSessionHasNoErrors();
        $this->assertEquals('superemaildeprueba433@gmail.com', $user->fresh()->email);
    }

    public function test_can_update_both_name_and_email(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->put(
            'user/profile-information',
            [
                'nombre' => 'Antonio Bragueta',
                'correo' => 'superemaildeprueba433@gmail.com',
            ]
        );
        $response->assertSessionHasNoErrors();
        $this->assertEquals('Antonio Bragueta', $user->fresh()->name);
        $this->assertEquals('superemaildeprueba433@gmail.com', $user->fresh()->email);
    }

}
