<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

class UpdateUserPassword implements UpdatesUserPasswords
{
    use PasswordValidationRules;

    /**
     * Validate and update the user's password.
     *
     * @param  array<string, string>  $input
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'contraseña_actual' => ['required', 'string', 'current_password:web'],
            'contraseña' => $this->passwordRules(),
        ], [
            'contraseña_actual.current_password' => __('La contraseña ingresada no coincide con la contraseña registrada.'),
        ])->validateWithBag('updatePassword');

        $user->forceFill([
            'password' => Hash::make($input['contraseña']),
        ])->save();
    }
}
