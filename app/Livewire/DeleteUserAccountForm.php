<?php

namespace App\Livewire;

use App\Actions\Jetstream\DeleteUser;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class DeleteUserAccountForm extends Component
{
    public $legend = 'Necesario pasar valor al atributo legend';

    public $showModal = false;

    #[Validate('required|current_password:web')]
    public $contraseña = '';

    public function unhideModal()
    {
        $this->showModal = true;
    }

    public function hideModal()
    {
        $this->showModal = false;
    }

    public function deleteAccount()
    {
        $this->validate();
        $deleteUser = new DeleteUser;
        $deleteUser->delete(Auth::user());
        return redirect()->route('welcome');
    }

    public function render()
    {
        return view('livewire.delete-user-account-form');
    }
}
