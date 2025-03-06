<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
                'nombre' => ['required', 'string', 'max:255'],
                'correo' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')],
                'contraseña' => $this->passwordRules(),
                // Activar opción en config/jestream.php cuando se implemente el sistema
                // de términos y política de privacidad
                'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            ],
            [
                'contraseña.confirmed' => 'La confirmación de contraseña no coincide con la contraseña provista.'
            ]
        )->validate();

        return User::create([
            'name' => $input['nombre'],
            'email' => $input['correo'],
            'password' => Hash::make($input['contraseña']),
        ]);
    }
}
