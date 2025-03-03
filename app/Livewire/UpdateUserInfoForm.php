<?php

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Component;

class UpdateUserInfoForm extends Component
{
    public $legend = "Espacio disponible para publicidad";
    public $action;
    public $method;
    public $atMethod;
    public $btnText;

    #[Validate('required')]
    public $nombre;
    #[Validate('required|email')]
    public $correo;

    public function runValidations()
    {
        $this->validate();
        return;
    }

    public function render()
    {
        return view('livewire.update-user-info-form');
    }
}
