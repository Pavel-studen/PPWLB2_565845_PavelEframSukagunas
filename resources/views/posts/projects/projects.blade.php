<x-app-layout>
    <div class="row g-4">
        @foreach($projects as $project)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    @if($project->thumbnail)
                        <img src="{{ Storage::url($project->thumbnail) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <span class="badge bg-primary mb-2">{{ $project->category->name ?? 'Umum' }}</span>
                        <h5 class="card-title fw-bold">{{ $project->name }}</h5>
                        <a href="{{ route('projects.show', $project) }}" class="btn btn-sm btn-outline-primary mt-2">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>