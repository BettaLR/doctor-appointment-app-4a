@props(['tab', 'error' => false])

<li class="me-2">
    <a href="#" x-on:click.prevent="tab = '{{ $tab }}'"
        :class="{
            'text-red-600 border-red-600': {{ $error ? 'true' : 'false' }} && tab !== '{{ $tab }}',
            'text-blue-600 border-blue-600 active': tab === '{{ $tab }}' && !{{ $error ? 'true' : 'false' }},
            'text-red-600 border-red-600 active': tab === '{{ $tab }}' && {{ $error ? 'true' : 'false' }},
            'border-transparent hover:text-blue-600 hover:border-gray-300': tab !== '{{ $tab }}' && !{{ $error ? 'true' : 'false' }}
        }"
        class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group transition-all duration-200"
        :aria-current="tab === '{{ $tab }}' ? 'page' : undefined">
        {{ $slot }}
        @if ($error)
            <i class="fa-solid fa-circle-exclamation ms-2 animate-pulse"></i>
        @endif
    </a>
</li>
