<x-app-layout>
    @if ($project->thumbnail)
        <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->name }}" class="w-full h-auto mb-4">
    @endif
    @foreach ($project->images as $img)
        <img src="{{ asset('storage/' . $img->image) }}" alt="{{ $img->caption ?: $project->name }}">
    @endforeach
</x-app-layout>