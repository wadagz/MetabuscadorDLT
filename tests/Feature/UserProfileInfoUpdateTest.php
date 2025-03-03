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

    public function test_error_message_email_not_unique(): void
    {
        $user = User::factory()->create();
        $other_user = User::factory()->create([
            'email' => 'correo_de_prueba33@gmail.com',
        ]);

        $response = $this->actingAs($user)->put(
            'user/profile-information',
            [
                'nombre' => 'Antonio Bragueta',
                'correo' => 'correo_de_prueba33@gmail.com',
            ]
        );
        $response->assertSessionHasErrors(['correo' => 'El correo ya ha sido tomado.']);
        $this->assertNotEquals($user->email, $other_user->email);
    }

    public function test_error_message_name_required(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->put(
            'user/profile-information',
            [
                'nombre' => '',
                'correo' => 'correo_de_prueba33@gmail.com',
            ]
        );
        $response->assertSessionHasErrors(['nombre']);
        $this->assertNotEquals($user->name, '');
    }

}
