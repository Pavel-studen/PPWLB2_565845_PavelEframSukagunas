<x-app-layout>
    <div class="bg-white p-4 rounded shadow-sm mb-4">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">Edit Project</h2>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Memperbarui data dan thumbnail --}}
        <form action="{{ route('post.projects.update', $project) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama Project</label>
                <input type="text" name="name" value="{{ old('name', $project->name) }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select name="category_id" class="form-select" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected($project->category_id == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label d-block">Thumbnail Saat Ini</label>
                @if($project->thumbnail)
                    <img src="{{ Storage::url($project->thumbnail) }}" alt="Thumbnail" width="160" class="rounded mb-2 border">
                @else
                    <p class="text-muted small">Belum ada thumbnail.</p>
                @endif

                <input type="file" name="thumbnail" accept="image/*" class="form-control mt-2">
                <div class="form-text">Kosongkan jika tidak ingin mengganti gambar. Maksimal 2MB (min 400x300 px).</div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('post.projects.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>

    {{-- Mengunggah multiple gallery --}}
    <div class="bg-white p-4 rounded shadow-sm">
        <h3 class="h5 fw-bold mb-3">Gallery Project</h3>

        <form action="{{ route('post.projects.gallery.store', $project) }}" method="POST" enctype="multipart/form-data" class="mb-4">
            @csrf
            <div class="input-group">
                <input type="file" name="images[]" multiple accept="image/*" class="form-control" required>
                <button type="submit" class="btn btn-success">Unggah Gambar</button>
            </div>
        </form>

        {{-- Daftar gambar gallery dan tombol hapus --}}
        <div class="row g-3">
            @foreach($project->images as $img)
                <div class="col-md-3 text-center">
                    <div class="border rounded p-2">
                        <img src="{{ Storage::url($img->image) }}" class="img-fluid rounded mb-2" style="height: 120px; object-fit: cover;">
                        <form action="{{ route('post.projects.gallery.order', [$project, $img]) }}" method="POST" class="d-flex gap-1 mb-2">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="sort_order" value="{{ $img->sort_order }}" class="form-control form-control-sm" min="0" title="Urutan tampil">
                            <button type="submit" class="btn btn-sm btn-outline-primary">Urut</button>
                        </form>
                        <form action="{{ route('post.projects.gallery.caption', [$project, $img]) }}" method="POST" class="d-flex gap-1 mb-2">
                            @csrf
                            @method('PATCH')
                            <input type="text" name="caption" value="{{ $img->caption }}" placeholder="Caption..." class="form-control form-control-sm">
                            <button type="submit" class="btn btn-sm btn-secondary">Simpan</button>
                        </form>
                        <form action="{{ route('post.projects.gallery.destroy', [$project, $img]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger w-100" onclick="return confirm('Hapus gambar ini?')">Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
