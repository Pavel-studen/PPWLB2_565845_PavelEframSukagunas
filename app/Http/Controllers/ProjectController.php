<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('category')->latest()->paginate(10);
        return view('posts.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('posts.projects.create', [
            'categories' => Category::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048|dimensions:min_width=400,min_height=300',
        ]);

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = 'projects/thumbnails/' . Str::uuid() . '.webp';

            $encoded = Image::read($file)->scaleDown(width: 1200)->toWebp(80);
            Storage::disk('public')->put($filename, $encoded);

            $validated['thumbnail'] = $filename;
        }

        Project::create($validated);

        return redirect()->route('post.projects.index')->with('success', 'Project successfully created.');
    }

    public function edit(Project $project)
    {
        $project->load('images');
        $categories = Category::all();
        return view('posts.projects.edit', compact('project', 'categories'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name'        => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048|dimensions:min_width=400,min_height=300',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($project->thumbnail) {
                Storage::disk('public')->delete($project->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('projects/thumbnails', 'public');
        }

        $project->update($validated);

        return redirect()->route('post.projects.index')->with('success', 'Project successfully updated.');
    }

    public function destroy(Project $project)
    {
        if ($project->thumbnail) {
            Storage::disk('public')->delete($project->thumbnail);
        }

        foreach ($project->images as $image) {
            Storage::disk('public')->delete($image->image);
        }

        $project->delete();

        return redirect()->route('post.projects.index')->with('success', 'Project deleted.');
    }
}
