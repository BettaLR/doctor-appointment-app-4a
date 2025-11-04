@props(['href' => null, 'blue' => false])

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => 'inline-flex items-center px-4 py-2 bg-' . ($blue ? 'blue' : 'black') . ' border border-' . ($blue ? 'blue' : 'black') . ' rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 focus:bg-gray-600 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-' . ($blue ? 'blue' : 'black') . ' focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150']) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-' . ($blue ? 'blue' : 'black') . ' border border-' . ($blue ? 'blue' : 'black') . ' rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 focus:bg-gray-600 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-' . ($blue ? 'blue' : 'black') . ' focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150']) }}>
        {{ $slot }}
    </button>
@endif
