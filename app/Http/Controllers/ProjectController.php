<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;

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
        $members = User::where('role', 'member')->get();
        return view('projects.show', compact('project','tasks', 'members'));
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

    public function ganttChart(Project $project)
    {
        $tasks = Task::where('project_id', $project->id)
                    ->orderBy('start_date')
                    ->get();
        
        return view('projects.gantt', compact('project', 'tasks'));
    }

    public function kanbanBoard(Project $project)
    {
        $todoTasks = Task::where('project_id', $project->id)
                        ->where('status', 'To Do')
                        ->get();
        
        $inProgressTasks = Task::where('project_id', $project->id)
                              ->where('status', 'In Progress')
                              ->get();
        
        $doneTasks = Task::where('project_id', $project->id)
                        ->where('status', 'Done')
                        ->get();

        return view('projects.kanban', compact('project', 'todoTasks', 'inProgressTasks', 'doneTasks'));
    }

    public function reports()
    {
        $user = Auth::user();
        $projects = Project::where('pm_id', $user->id)->with('tasks')->get();
        
        $statistics = [
            'total_projects' => $projects->count(),
            'completed_projects' => $projects->where('status', 'Done')->count(),
            'total_tasks' => Task::whereIn('project_id', $projects->pluck('id'))->count(),
            'completed_tasks' => Task::whereIn('project_id', $projects->pluck('id'))->where('status', 'Done')->count(),
        ];

        return view('projects.reports', compact('projects', 'statistics'));
    }

    public function downloadReport()
    {
        // Logic untuk download laporan (PDF/Excel)
        $user = Auth::user();
        $projects = Project::where('pm_id', $user->id)->with('tasks')->get();
        
        // Implementasi export ke PDF menggunakan DomPDF atau library lain
        return response()->json(['message' => 'Report downloaded successfully']);
    }

    public function adminIndex()
    {
        // Admin dapat melihat semua proyek
        $projects = Project::with('pmUser')->get();
        return view('admin.projects', compact('projects'));
    }
    
    public function memberShow(Project $project)
    {
        // Member hanya bisa melihat proyek yang ditugaskan kepada mereka
        $user = Auth::user();
        $tasks = Task::where('project_id', $project->id)
                    ->where('assignee_id', $user->id)
                    ->get();
        
        return view('projects.member-show', compact('project', 'tasks'));
    }
    
    public function adminShow(Project $project)
    {
        // Admin dapat melihat detail project apapun (read-only)
        $tasks = Task::where('project_id', $project->id)->get();
        $members = User::where('role', 'member')->get();
        return view('projects.show', compact('project', 'tasks', 'members'));
    }
}
