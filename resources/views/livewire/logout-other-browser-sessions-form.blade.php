<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Browser Sessions') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Manage and log out your active sessions on other browsers and devices.') }}
        </p>
    </header>

    <div class="mt-6">
        <p class="text-sm text-gray-600">
            {{ __('If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.') }}
        </p>
    </div>

    <div class="mt-6">
        <x-primary-button wire:click="logoutOtherBrowserSessions" wire:confirm="Are you sure you want to log out of all other browser sessions?">
            {{ __('Log Out Other Browser Sessions') }}
        </x-primary-button>

        <x-action-message class="mt-3" on="saved">
            {{ __('Done.') }}
        </x-action-message>
    </div>
</section>
