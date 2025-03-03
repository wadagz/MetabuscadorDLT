<?php

namespace Tests\Feature\Livewire;

use App\Livewire\UpdateUserInfoForm;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

class UpdateUserInfoFormTest extends TestCase
{
    use DatabaseTransactions;

    public function renders_successfully()
    {
        Livewire::test(UpdateUserInfoForm::class)
            ->assertStatus(200);
    }

    public function test_can_see_error_message_name_required()
    {
        $this->actingAs($user = User::factory()->create());
        Livewire::test(UpdateUserInfoForm::class)
            ->set('nombre', '')
            ->set('correo', $user->mail)
            ->call('runValidations')
            ->assertHasErrors('nombre');
    }

    public function test_can_see_error_message_email_not_valid()
    {
        $this->actingAs($user = User::factory()->create());
        Livewire::test(UpdateUserInfoForm::class)
            ->set('nombre', $user->name)
            ->set('correo', 'estenoesuncorreovalido')
            ->call('runValidations')
            ->assertHasErrors('correo')
            ->assertSeeText('El campo correo debe ser una dirección de correo electrónico válida.');
    }

}
