<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LogoutOtherBrowserSessionsForm extends Component
{
    public string $password = '';

    public function logoutOtherBrowserSessions(): void
    {
        $this->validate([
            'password' => ['required', 'current_password'],
        ]);

        Auth::logoutOtherDevices($this->password);

        $this->reset();
        $this->dispatch('saved');
    }

    public function render()
    {
        return view('livewire.logout-other-browser-sessions-form');
    }
}
