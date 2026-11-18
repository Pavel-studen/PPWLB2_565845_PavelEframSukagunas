<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::query();
        $query->when($request->search, function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%');
        });
        $query->when($request->category, function ($q) use ($request) {
            $q->whereHas('category', function ($q) use ($request) {
                $q->where('category_id', $request->category);
            });
        });
        switch ($request->query('sort')){
            case 'terlama':
                $query->oldest();
                break;
            case 'az':
                $query->orderBy('name');
                break;
            default:
                $query->latest();
        }
        // $projects = Project::with('category')->latest()->paginate(9);
        $projects = $query->paginate(9)->withQueryString();
        $categories = \App\Models\Category::orderBy('name')->get();
        return view('posts.projects.index', compact('projects', 'categories'));
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
            'name'              => 'required|max:255|unique:projects,name',
            'category_id'       => 'required|exists:categories,id',
            'short_description' => 'nullable|max:255',
            'description'       => 'nullable',
            'status'            => 'required|in:draft,published',
            'project_url'       => 'nullable|url|max:255',
            'repository_url'    => 'nullable|url|max:255',
            'thumbnail'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048|dimensions:min_width=400,min_height=300',
            'technologies'      => 'nullable|array',
            'technologies.*'    => 'exists:technologies,id',
        ]);

        if ($request->hasFile('thumbnail')) {
            // $file = $request->file('thumbnail');
            // $filename = 'projects/thumbnails/' . Str::uuid() . '.webp';

            // $encoded = Image::read($file)->scaleDown(width: 1200)->toWebp(80);
            // Storage::disk('public')->put($filename, $encoded);

            // $validated['thumbnail'] = $filename;
            $validated['thumbnail'] = $request->file('thumbnail')->store('projects/thumbnails', 'public');
        }

        $validated['slug'] = Str::slug($validated['name']);

        $technologyIds = $validated['technologies'] ?? [];
        unset($validated['technologies']);

        $project = Project::create($validated);
        $project->technologies()->attach($technologyIds);

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
