<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Task;

class ProjectController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role !== 'pm') {
            // Only PMs manage projects here
            return redirect()->route('dashboard');
        }

        $projects = Project::where('pm_id', $user->id)->get();
        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        $tasks = Task::where('project_id', $project->id)->get();
        return view('projects.show', compact('project','tasks'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);
        
        $data['pm_id'] = Auth::id();
        $data['status'] = 'To Do';
        
        Project::create($data);
        
        return redirect()->route('projects.index')->with('status', 'Proyek berhasil dibuat!');
    }
}
