<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <x-stat-card label="Projects" :value="$totalProjects" />
        <x-stat-card label="Categories" :value="$totalCategories" color="text-green-600" />
        <x-stat-card label="Technologies" :value="$totalTechnologies" color="text-purple-600" />
        <x-stat-card label="Skills" :value="$totalSkills" color="text-orange-600" />
    </div>
</x-app-layout>
