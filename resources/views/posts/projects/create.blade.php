<x-app-layout>
    <form action="{{ route('post.projects.store') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf

        <input type="text" name="name" value="{{ old('name') }}">
        @error('name')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    
        <select name="category_id">
            <option value="">Pilih kategori</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

        <input type="file" name="thumbnail" accept="image/*">
        @error('thumbnail')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror

        <button type="submit">Simpan</button>
    </form>
</x-app-layout>