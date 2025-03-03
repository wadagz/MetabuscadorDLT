<?php

namespace App\Livewire;

use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Validate;
use Livewire\Component;

class UpdatePassword extends Component
{
    public $legend = "Ponga su publicidad aquí";

    public $contraseña_actual;
    #[Validate]
    public $contraseña;
    #[Validate]
    public $contraseña_confirmation;

    public function rules()
    {
        return [
            'contraseña_actual' => ['required', 'current_password:web'],
            'contraseña' => ['required', 'different:contraseña_actual', Password::default()],
            'contraseña_confirmation' => ['required', 'confirmed:contraseña'],
        ];
    }

    public function runValidations()
    {
        $this->validate();
        return;
    }

    public function messages()
    {
        return [
            'contraseña_confirmation.confirmed' => 'Los campos contraseña nueva y confirmar contraseña no coinciden.',
        ];
    }

    public function render()
    {
        return view('livewire.update-password');
    }
}
