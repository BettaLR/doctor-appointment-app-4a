<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Two Factor Authentication') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Add additional security to your account using two factor authentication.') }}
        </p>
    </header>

    @if (auth()->user()->two_factor_secret)
        <h3 class="text-md font-medium text-gray-900 mt-6">
            {{ __('Two factor authentication is enabled.') }}
        </h3>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone\'s Google Authenticator application.') }}
        </p>

        <div class="mt-4">
            <x-primary-button wire:click="showRecoveryCodes">
                {{ __('Show Recovery Codes') }}
            </x-primary-button>

            <x-secondary-button class="ml-3" wire:click="disableTwoFactorAuthentication" wire:confirm="Are you sure you want to disable two factor authentication?">
                {{ __('Disable') }}
            </x-secondary-button>
        </div>

        @if ($showingRecoveryCodes)
            <div class="mt-4 p-4 bg-gray-100 rounded">
                <h4 class="text-sm font-medium text-gray-900">{{ __('Recovery Codes:') }}</h4>
                <p class="mt-1 text-sm text-gray-600">{{ __('Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.') }}</p>
                <div class="mt-2 text-sm text-gray-800">{{ implode(', ', json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true)) }}</div>
            </div>
        @endif
    @else
        <h3 class="text-md font-medium text-gray-900 mt-6">
            {{ __('You have not enabled two factor authentication.') }}
        </h3>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone\'s Google Authenticator application.') }}
        </p>

        <div class="mt-4">
            <x-primary-button wire:click="enableTwoFactorAuthentication">
                {{ __('Enable') }}
            </x-primary-button>
        </div>
    @endif

    @if ($showingQrCode)
        <div class="mt-4 p-4 bg-gray-100 rounded">
            <p class="text-sm text-gray-600">{{ __('Two factor authentication is now enabled. Scan the following QR code using your phone\'s authenticator application.') }}</p>
            <!-- QR Code would be displayed here -->
        </div>
    @endif
</section>
