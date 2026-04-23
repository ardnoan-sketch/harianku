@php
    $isEdit      = isset($user);
    $action      = $isEdit ? route('admin.users.update', $user->id) : route('admin.users.store');
    $method      = $isEdit ? 'PUT' : null;
    $pageTitle   = $isEdit ? "Edit User: {$user->name}" : 'Add New User';
    $breadLast   = $isEdit ? 'Edit' : 'Add New';
    $submitLabel = $isEdit ? 'Update User' : 'Save User';
    $formDesc    = $isEdit ? 'Update user information or assign/revoke roles.' : 'Add a new user to the system and assign appropriate roles.';
@endphp
<x-app-layout>
    <x-ui.page-header :title="$pageTitle" :breadcrumbs="['Administrator', ['label' => 'Users', 'url' => route('admin.users.index')], $breadLast]" />

    <x-ui.page-container narrow padding="normal">
            <x-form :action="$action" :method="$method" cancelRoute="{{ route('admin.users.index') }}" :submitLabel="$submitLabel" title="User Profile" :description="$formDesc">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-1 md:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-span-1 md:col-span-2">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    @if($isEdit)
                        <div class="col-span-1 md:col-span-2 bg-gray-50 p-4 rounded-md border border-gray-200 mt-2">
                            <h4 class="text-sm font-medium text-gray-700 mb-4">Change Password (Leave blank to keep current)</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="col-span-1">
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                                    <input type="password" name="password" id="password" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-span-1">
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-span-1">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password" id="password" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-span-1">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    @endif
                    <div class="col-span-1 md:col-span-2 mt-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Access Roles</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($roles as $role)
                                <div class="flex items-center">
                                    <input id="role_{{ $role->id }}" name="roles[]" value="{{ $role->name }}" type="checkbox"
                                        {{ isset($userRoles) && in_array($role->name, $userRoles) ? 'checked' : '' }}
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="role_{{ $role->id }}" class="ml-2 block text-sm text-gray-900">{{ $role->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
        </x-form>
    </x-ui.page-container>
</x-app-layout>
