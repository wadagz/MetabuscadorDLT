<?php

namespace Tests\Feature;

use App\Livewire\UpdatePassword;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class UserPasswordUpdateTest extends TestCase
{
    use DatabaseTransactions;

    public function test_can_update_password(): void
    {
        $user = User::factory()->create();
        $new_password = 'Minuevasuperpassword1!';
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

    public function test_error_message_contraseña_actual(): void
    {
        $this->actingAs(User::factory()->create());
        Livewire::test(UpdatePassword::class)
            ->set('contraseña_actual', 'contraseñaincorrecta')
            ->set('contraseña', 'Misupernuevacontraseña1!')
            ->set('contraseña_confirmation', 'Misupernuevacontraseña1!')
            ->call('runValidations')
            ->assertHasErrors('contraseña_actual');
    }

    public function test_can_see_error_message_password_no_meets_rules()
    {
        $contraseña_actual = 'password';
        $contraseña = 'contra';
        $contraseña_confirmation = 'contra';
        $this->actingAs(User::factory()->create());
        Livewire::test(UpdatePassword::class)
            ->set('contraseña_actual', $contraseña_actual)
            ->set('contraseña', $contraseña)
            ->set('contraseña_confirmation', $contraseña_confirmation)
            ->call('runValidations')
            ->assertHasErrors('contraseña')
            ->assertSeeText('El campo contraseña debe tener al menos 8 caracteres.')
            ->assertSeeText('El campo contraseña debe contener al menos una letra mayúscula y una minúscula.')
            ->assertSeeText('El campo contraseña debe contener al menos un símbolo.')
            ->assertSeeText('El campo contraseña debe contener al menos un número.');
    }

    public function test_can_see_error_message_password_same_as_current_password()
    {
        $contraseña_actual = 'Misupernuevacontraseña1!';
        $contraseña = 'Misupernuevacontraseña1!';
        $contraseña_confirmation = 'Misupernuevacontraseña1!';
        $this->actingAs(User::factory()->create());
        Livewire::test(UpdatePassword::class)
            ->set('contraseña_actual', $contraseña_actual)
            ->set('contraseña', $contraseña)
            ->set('contraseña_confirmation', $contraseña_confirmation)
            ->call('runValidations')
            ->assertHasErrors('contraseña')
            ->assertSeeText('El campo contraseña y contraseña actual deben ser diferentes.');
    }

    public function test_can_see_error_message_password_not_confirmed(): void
    {
        $this->actingAs(User::factory()->create());
        Livewire::test(UpdatePassword::class)
            ->set('contraseña_actual', 'password')
            ->set('contraseña', 'Misupernuevacontraseña1!')
            ->set('contraseña_confirmation', 'Unacontradiferente1!')
            ->call('runValidations')
            ->assertHasErrors('contraseña_confirmation')
            ->assertSeeText('Los campos contraseña nueva y confirmar contraseña no coinciden.');
    }

}
