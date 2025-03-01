<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Tests\TestCase;

class UserPasswordUpdateTest extends TestCase
{
    use DatabaseTransactions;

    public function test_can_update_password(): void
    {
        $user = User::factory()->create();
        $new_password = 'new-password';
        $response = $this->actingAs($user)->put(
            'user/password',
            [
                'contraseña_actual' => 'password',
                'contraseña' => $new_password,
                'contraseña_confirmation' => $new_password,
            ]
        );

        $response->assertSessionHasNoErrors();
        $this->assertTrue(Hash::check($new_password, $user->fresh()->password));
    }

    public function test_can_see_error_message_contraseña_actual(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->put(
            'user/password',
            [
                'contraseña_actual' => 'contrasena-incorrecta',
                'contraseña' => 'new-password',
                'contraseña_confirmation' => 'new-password',
            ]
        );

        $response->assertSessionHasErrorsIn('updatePassword', 'contraseña_actual');
        $errors = session('errors');
        $this->assertTrue($errors->updatePassword->has('contraseña_actual'));
        $this->assertEquals('La contraseña ingresada no coincide con la contraseña registrada.', $errors->updatePassword->first('contraseña_actual'));
    }

    public function test_can_see_error_message_password_no_meets_rules(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->put(
            'user/password',
            [
                'contraseña_actual' => 'password',
                'contraseña' => 'corta',
                'contraseña_confirmation' => 'corta',
            ]
        );
        $response->assertSessionHasErrorsIn('updatePassword', 'contraseña');
        $errors = session('errors');
        $this->assertTrue($errors->updatePassword->has('contraseña'));
        $this->assertEquals('El campo contraseña debe tener al menos 8 caracteres.', $errors->updatePassword->first('contraseña'));
    }

    public function test_can_see_error_message_password_not_confirmed(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->put(
            'user/password',
            [
                'contraseña_actual' => 'password',
                'contraseña' => 'new-password',
                'contraseña_confirmation' => 'otra-password',
            ]
        );
        $response->assertSessionHasErrorsIn('updatePassword', 'contraseña');
        $errors = session('errors');
        $this->assertTrue($errors->updatePassword->has('contraseña'));
        $this->assertEquals('El campo contraseña no coincide.', $errors->updatePassword->first('contraseña'));
    }

}
