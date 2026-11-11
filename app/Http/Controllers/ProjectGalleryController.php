<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class ProjectGalleryController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'images'   => 'required|array|max:10',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:4096|dimensions:min_width=800',
        ], [
            'images.max'          => 'Maksimal 10 gambar dalam sekali unggah.',
            'images.*.dimensions' => 'Mohon maaf, gambar gallery harus memiliki lebar minimal 800 px.',
        ]);
        foreach ($request->file('images') as $file){
            // $project->images()->create([
            //     'image' => $file->store('projects/gallery', 'public'),
            // ]);

            $filename = 'projects/gallery/' . Str::uuid() . '.webp';
            $encoded = Image::read($file)->scaleDown(width: 1600)->toWebp(80);
            Storage::disk('public')->put($filename, $encoded);
            $project->images()->create(['image' => $filename]);
        }
        return back()->with('success', 'Gallery image successfully uploaded.');
    }

    public function updateOrder(Request $request, Project $project, ProjectImage $image)
    {
        abort_if($image->project_id !== $project->id, 404);
        $validated = $request->validate([
            'sort_order' => 'required|integer|min:0',
        ]);
        $image->update(['sort_order' => $validated['sort_order']]);
        return back()->with('success', 'Image order successfully updated.');
    }

    public function updateCaption(Request $request, Project $project, ProjectImage $image)
    {
        abort_if($image->project_id !== $project->id, 404);
        $validated = $request->validate([
            'caption' => 'nullable|string|max:255',
        ]);
        $image->update(['caption' => $validated['caption']]);
        return back()->with('success', 'Image caption updated.');
    }

    public function destroy(Project $project, ProjectImage $image)
    {
        abort_if($image->project_id !== $project->id, 404);
        Storage::disk('public')->delete($image->image);
        $image->delete();
        return back()->with('success', 'Image deleted.');
    }
}
