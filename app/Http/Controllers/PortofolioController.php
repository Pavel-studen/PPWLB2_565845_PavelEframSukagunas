<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PortofolioController extends Controller
{
    public function home()
    {
        return view('posts.projects.home');
    }

    public function about()
    {
        return view('posts.projects.about');
    }

    public function education()
    {
        return view('posts.projects.education');
    }

    public function projects()
    {
        return view('posts.projects', ['projects' => \App\Models\Project::with('category')->latest()->get()]);
    }

    public function show(\App\Models\Project $project)
    {
        $project->load(['category', 'images']);
        return view('posts.projects.portofolio', compact('project'));
    }
}
