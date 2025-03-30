<?php

namespace App\Livewire;

use Livewire\Component;
use App\Enums\PreferenciaEnum;
use Illuminate\Support\Facades\Auth;

class UserPreferenceForm extends Component
{
    public array $pregunta1;
    public array $pregunta2;
    public array $pregunta3;
    public array $pregunta4;
    public array $pregunta5;

    public $currentPreferences;

    public function mount()
    {
        // Obtiene los datos de las preferencias divididos por pregunta.
        $this->pregunta1 = PreferenciaEnum::numPregunta(1);
        $this->pregunta2 = PreferenciaEnum::numPregunta(2);
        $this->pregunta3 = PreferenciaEnum::numPregunta(3);
        $this->pregunta4 = PreferenciaEnum::numPregunta(4);
        $this->pregunta5 = PreferenciaEnum::numPregunta(5);

        // Obtiene las preferencias actuales del usuario.
        $user = Auth::user();
        $this->currentPreferences = $user->preferencias;
        $this->currentPreferences = $this->currentPreferences->map(function ($preferencia) {
            return $preferencia->id;
        });
    }

    public function render()
    {
        return view('livewire.user-preference-form');
    }
}
