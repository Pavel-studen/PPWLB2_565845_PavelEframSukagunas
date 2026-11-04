<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Informasi Akun</h3>
                    
                    <div class="mb-2">
                        <span class="font-semibold">Nama:</span> 
                        {{ Auth::user()->name }}
                    </div>
                    
                    <div class="mb-2">
                        <span class="font-semibold">Email:</span> 
                        {{ Auth::user()->email }}
                    </div>

                    <div class="mb-2">
                        <span class="font-semibold">Role:</span> 
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-sm capitalize">
                            {{ Auth::user()->role ?? 'user' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>