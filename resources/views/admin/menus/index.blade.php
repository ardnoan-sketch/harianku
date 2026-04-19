<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-ui.page-header title="Daftar Menu" :breadcrumbs="['Administrator', 'Menus']" />
            <x-ui.alert type="success" />
            <x-ui.alert type="error" />

            <x-grid 
                title="Daftar Menu" 
                description="Kelola menu sidebar untuk seluruh modul di aplikasi."
                createRoute="{{ route('admin.menus.create') }}"
                createLabel="Tambah Menu"
                :headers="['Order', 'Name', 'Module', 'Parent', 'Icon Type', 'Route/URL', 'Actions']"
                :pagination="$menus"
            >
                @foreach($menus as $menu)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $menu->order_no }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $menu->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $menu->module }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $menu->parent ? $menu->parent->name : '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $menu->icon_type }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $menu->url_or_route }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('admin.menus.edit', $menu->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3"><i class="bx bx-edit text-lg"></i></a>
                        <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus menu ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900"><i class="bx bx-trash text-lg"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </x-grid>
        </div>
    </div>
</x-app-layout>
