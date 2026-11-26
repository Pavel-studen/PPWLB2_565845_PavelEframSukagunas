<?php

namespace App\Http\Controllers\Api;

use App\Models\Project;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with(['category', 'technologies'])
            ->where('status', 'published')
            ->latest()
            ->paginate(9);
        return ProjectResource::collection($projects);
    }

    public function show(Project $project)
    {
        return new ProjectResource($project->load(['category', 'technologies']));
    }
}
