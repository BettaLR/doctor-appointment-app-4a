@props(['tab', 'error' => false])
<div x-show="tab === '{{ $tab }}'" style="display: none">
    {{ $slot }}
</div>
