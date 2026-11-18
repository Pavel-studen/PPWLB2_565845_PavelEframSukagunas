<x-app-layout>
    <form action="{{ route('post.projects.store') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf

        <div>
            <label>Nama Project</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
            @error('name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
    
        <div>
            <label>Kategori</label>
            <select name="category_id" required>
                <option value="">Pilih kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>Ringkasan Singkat</label>
            <input type="text" name="short_description" value="{{ old('short_description') }}">
            @error('short_description')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>Deskripsi</label>
            <textarea name="description">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>Status</label>
            <select name="status" required>
                <option value="published" @selected(old('status') === 'published')>Published</option>
                <option value="draft" @selected(old('status') === 'draft')>Draft</option>
            </select>
            @error('status')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        @isset($technologies)
        <div>
            <label>Technologies</label>
            @foreach ($technologies as $tech)
                <label>
                    <input type="checkbox" name="technologies[]" value="{{ $tech->id }}"
                        @checked(in_array($tech->id, old('technologies', [])))>
                    {{ $tech->name }}
                </label>
            @endforeach
            @error('technologies')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        @endisset

        <div>
            <label>Project URL</label>
            <input type="url" name="project_url" value="{{ old('project_url') }}" placeholder="https://...">
            @error('project_url')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>Repository URL</label>
            <input type="url" name="repository_url" value="{{ old('repository_url') }}" placeholder="https://github.com...">
            @error('repository_url')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>Thumbnail</label>
            <input type="file" name="thumbnail" accept="image/*">
            @error('thumbnail')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit">Simpan</button>
    </form>
</x-app-layout>