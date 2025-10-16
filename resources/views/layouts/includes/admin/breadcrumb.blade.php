{{-- Verifica si hay un elemento en breadcrumb --}}
@if (count($breadcrumbs))
    {{-- Margin botton o margen inferior --}}
    <nav class="mb-4 block">
        <ol class="flex flex-wrap items-center text-gray-600 text-sm">
            @foreach ($breadcrumbs as $item)
                <li class="flex items-center">
                    @unless ($loop->first)
                        <span class="px-2 text-gray-400">/</span>
                    @endunless

                    {{-- Revisar si existe una llave llamada 'href' --}}
                    @isset($item['href'])
                        <a href="{{ $item['href'] }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                            {{ $item['name'] }}
                        </a>

                    @else
                        <span class="text-gray-900 font-medium">{{ $item['name'] }}</span>
                    @endisset

                </li>
            @endforeach
        </ol>
        <!-- El ultimo item aparece resaltado -->
        @if (count($breadcrumbs) > 1)
            <h1 class="text-2xl font-bold text-gray-900 mt-2">
                {{ end($breadcrumbs)['name'] }}
            </h1>

        @endif
    </nav>
@endif
