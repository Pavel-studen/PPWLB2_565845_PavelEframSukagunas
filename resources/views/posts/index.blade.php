<x-app-layout>
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
        <h1>Blog Posts</h1>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success')}}</div>
        @endif

        @if(count($posts)>0)
            @foreach ($posts as $post)
            <div class="well">
                <h3>{{$posts->firstItem() + $loop->index}}</h3>
                <h3><a href="/posts/{{$post->id}}">
                {{$post->title}}</a></h3>
                <small>Tanggal:
                {{$post->created_at}}</small>
            </div>
            @endforeach
            <div class="mt-4 text-sm text-gray-600">
                Halaman : {{ $posts->currentPage() }} <br>
                Jumlah Data : {{ $posts->total() }} <br>
                Data Per Halaman : {{ $posts->perPage() }} <br>
            </div>
            <div class="mt-4">
                {{ $posts->links() }}
            </div>
            <form method="GET" action="{{ route('posts.index') }}">
                @if (request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                <select name="perPage" onchange="this.form.submit()">
                    <option value="5" {{ request('perPage') == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                </select>
            </form>
        @else
            <h3>No data.</h3>
        @endif
        <a href="{{ route('posts.create') }}">Create New Post</a>
        </div>
    </div>
</x-app-layout>