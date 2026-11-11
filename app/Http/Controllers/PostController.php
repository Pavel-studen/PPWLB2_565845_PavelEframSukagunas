<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //$data = array(
        //    'id' => "posts",
        //    'posts' => Post::all()
        //);
        //return view('posts.index')->with($data);

        //$totalPosts = Post::count();
        //$latestPost = Post::latest()->first();
        //$maxId = Post::max('id');
        //return view('posts', compact('totalPosts', 'latestPost', 'maxId'));

        // $query = Post::query();
        // if ($request->filled('search')) {  
        //     $query->search($request->search);
        // }
        // $posts = $query->paginate(10)->withQueryString();
        $perPage = $request->input('perPage', 10);
        $posts = Post::paginate($perPage)->withQueryString();
        return view('posts.index', compact('post'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $post = new Post();
        // $post->title = $request->input('title');
        // $post->description = $request->input('description');
        // $post->save();
        // return redirect()->route('posts.index');

        // $request->validate([
        //     'title' => 'required|max:200',
        //     'description' => 'required',
        // );

        // Post::create([
        //     'title' => $request->title,
        //     'description' => $request->description,
        // ]);

        $validatedData = $request->validate([
            'title'       => 'required|string|max:200',
            'description' => 'required|string',
        ]);
        Post::create($validatedData);
        return redirect()->route('posts.index')->with('success', 'New Data successfully added');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = array(
            'id' => "posts",
            'posts' => Post::find($id)
        );
        return view('posts.show')->with($data);

        $post = Post::find($id);
        if (!$post) {
            abort(404);
        }
        $post = \App\Models\Post::findOrFail($id);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        $data = [ 'post' => $post, ];
        return view('posts.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
        
        $post = Post::findOrFail($id);
        $post->update($validatedData);
        
        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Data successfully deleted.');
    }
    public function home()
    {
        return view('posts.home');
    }
}
