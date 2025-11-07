{{-- resources/views/components/wire-card.blade.php --}}
<div class="bg-white shadow-md rounded-2xl p-6 border border-gray-200">
    @isset($title)
        <h2 class="text-xl font-semibold mb-4">{{ $title }}</h2>
    @endisset

    {{ $slot }}
</div>
