<x-app-layout>
    <div class="p-5 mb-4 bg-white rounded-3 shadow-sm">
        <div class="container-fluid py-3">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome</h1>
            <p class="text-base">This is the home page.</p>
        </div>
    </div>
</x-app-layout>

@push('scripts')
    <script>console.log('home loaded');</script>
@endpush
