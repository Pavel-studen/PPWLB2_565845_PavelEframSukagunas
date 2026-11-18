@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Projects</h2>
    
    <div style="margin-bottom: 15px;">
        <a href="{{ url('/post/projects/create') }}">+ Tambah Project</a>
    </div>

    <form method="GET" action="{{ url('/post/projects') }}" style="margin-bottom: 1rem; display: flex; gap: 0.5rem;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari project...">
        
        <select name="category">
            <option value="">Semua kategori</option>
            @foreach ($categories as $c)
                <option value="{{ $c->id }}" @selected(request('category') === $c->id)>
                    {{ $c->name }}
                </option>
            @endforeach
        </select>

        <select name="sort">
            <option value="terbaru" @selected(request('sort') === 'terbaru')>Terbaru</option>
            <option value="terlama" @selected(request('sort') === 'terlama')>Terlama</option>
            <option value="az" @selected(request('sort') === 'az')>Judul A-Z</option>
        </select>

        <button type="submit">Cari</button>
    </form>

    <table style="width: 100%; text-align: left; border-collapse: collapse;">
        <thead>
            <tr style="border-bottom: 1px solid #ccc;">
                <th>No</th>
                <th>Thumbnail</th>
                <th>Nama Project</th>
                <th>Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($projects as $index => $project)
                <tr>
                    <td>{{ $projects->firstItem() + $index }}</td>
                    <td>
                        @if($project->thumbnail)
                            Ada
                        @else
                            Tidak ada
                        @endif
                    </td>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->category->name ?? '-' }}</td>
                    <td>
                        <a href="{{ url('/post/projects/'.$project->id.'/edit') }}">Edit</a>
                        
                        <form action="{{ url('/post/projects/'.$project->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; color: blue; cursor: pointer; text-decoration: underline;" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 20px;">Belum ada data project.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $projects->links() }}
</div>
@endsection