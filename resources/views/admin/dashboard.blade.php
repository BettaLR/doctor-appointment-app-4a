<x-admin-layout :breadcrumbs="[
    [
    'name' => 'Dashboard',
    'href' => route('admin.dashboard'),
    ],
    [
    'name' => 'Profile',
    ],
]">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-gray-900 mb-4">Hola Mundo desde ADMIN</h1>
        <p class="text-gray-600">Bienvenido al panel de administración.</p>
    </div>

</x-admin-layout>
