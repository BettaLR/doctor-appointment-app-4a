<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TwoFactorAuthenticationForm extends Component
{
    public string $password = '';
    public bool $showingQrCode = false;
    public bool $showingRecoveryCodes = false;

    public function enableTwoFactorAuthentication(): void
    {
        $this->validate([
            'password' => ['required', 'current_password'],
        ]);

        Auth::user()->forceFill([
            'two_factor_secret' => encrypted_random_key(),
            'two_factor_recovery_codes' => encrypted_array(random_codes()),
        ])->save();

        $this->showingQrCode = true;
        $this->dispatch('enabled');
    }

    public function disableTwoFactorAuthentication(): void
    {
        $this->validate([
            'password' => ['required', 'current_password'],
        ]);

        Auth::user()->forceFill([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
        ])->save();

        $this->showingQrCode = false;
        $this->dispatch('disabled');
    }

    public function showRecoveryCodes(): void
    {
        $this->showingRecoveryCodes = true;
    }

    public function render()
    {
        return view('livewire.two-factor-authentication-form');
    }
}
