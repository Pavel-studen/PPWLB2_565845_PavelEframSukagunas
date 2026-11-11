<x-app-layout>
    <div class="bg-white p-4 rounded shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="text-3xl font-bold">Daftar Projects</h1>
            <a href="{{ route('post.projects.create') }}" class="btn btn-primary">+ Tambah Project</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($projects->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Thumbnail</th>
                            <th>Nama Project</th>
                            <th>Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projects as $project)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if($project->thumbnail)
                                        <img src="{{ Storage::url($project->thumbnail) }}" width="80" class="rounded">
                                    @else
                                        <span class="text-muted small">Tidak ada</span>
                                    @endif
                                </td>
                                <td>{{ $project->name }}</td>
                                <td>{{ $project->category->name ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('post.projects.edit', $project) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('post.projects.destroy', $project) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus project?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $projects->links() }}
        @else
            <p class="text-muted">Belum ada data project.</p>
        @endif
    </div>
</x-app-layout>