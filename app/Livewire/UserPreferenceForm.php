<?php

namespace App\Livewire;

use Livewire\Component;
use App\Enums\PreferenciaEnum;

class UserPreferenceForm extends Component
{
    public array $pregunta1;
    public array $pregunta2;
    public array $pregunta3;
    public array $pregunta4;
    public array $pregunta5;

    protected $listeners = ['submitFormData'];

    // Probando como procesar los datos del form
    // sin necesidad de hacer binding.
    public function submitFormData($formData)
    {
        // Loop through the FormData and process the values
        foreach ($formData as $key => $value) {
            // You can now process the $key (e.g., 'name', 'email', 'address')
            // and $value (the corresponding form value).
            dd($key, $value);
        }
    }

    public function mount()
    {
        $this->pregunta1 = PreferenciaEnum::numPregunta(1);
        $this->pregunta2 = PreferenciaEnum::numPregunta(2);
        $this->pregunta3 = PreferenciaEnum::numPregunta(3);
        $this->pregunta4 = PreferenciaEnum::numPregunta(4);
        $this->pregunta5 = PreferenciaEnum::numPregunta(5);
    }

    public function save()
    {
        dd(request());
        return;
    }

    public function render()
    {
        return view('livewire.user-preference-form');
    }
}
