<?php

namespace Tests\Feature;

use App\Livewire\DeleteUserAccountForm;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteUserTest extends TestCase
{
    use DatabaseTransactions;

    public function test_can_delete_account(): void
    {
        $this->actingAs($user = User::factory()->create());

        Livewire::test(DeleteUserAccountForm::class)
            ->set('contraseña', 'password')
            ->call('deleteAccount');

        $this->assertNull($user->fresh());
        $this->assertModelMissing($user);
    }

    public function test_correct_password_must_be_provided_before_account_can_be_deleted(): void
    {
        $this->actingAs($user = User::factory()->create());

        Livewire::test(DeleteUserAccountForm::class)
            ->set('contraseña', 'wrong-password')
            ->call('deleteAccount')
            ->assertHasErrors(['contraseña']);

        $this->assertNotNull($user->fresh());
    }
}
