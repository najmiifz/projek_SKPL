<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\NotificationItem;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            $tasks = Task::all();
            return view('tasks.index', compact('tasks'));
        }

        if ($user->role === 'pm') {
            $tasks = Task::whereHas('project', function($q) use ($user) { $q->where('pm_id', $user->id); })->get();
            return view('tasks.index', compact('tasks'));
        }

        // member
        $tasks = Task::where('assignee_id', $user->id)->get();
        return view('mytasks.index', compact('tasks'));
    }

    public function show(Task $task)
    {
        $task->load('assignee','project','comments.user');
        return view('tasks.show', compact('task'));
    }

    public function store(Request $request)
    {
        $data = $request->validate(['project_id'=>'required','title'=>'required','assignee_id'=>'required']);
        $task = Task::create($data + ['status' => 'To Do','progress' => 0]);

        // send notification to assignee
        NotificationItem::create([
            'user_id' => $data['assignee_id'],
            'message' => "Tugas baru \"{$task->title}\" ditugaskan kepada Anda.",
            'read' => false,
        ]);

        return redirect()->route('projects.show', $data['project_id']);
    }

    public function update(Request $request, Task $task)
    {
        $data = $request->only(['status','progress']);
        $oldStatus = $task->status;
        $task->update($data);

        // If submitted for review, notify PM
        if (isset($data['status']) && $data['status'] === 'Review') {
            $project = Project::find($task->project_id);
            if ($project) {
                NotificationItem::create([
                    'user_id' => $project->pm_id,
                    'message' => Auth::user()->name . " meminta review untuk tugas \"{$task->title}\".",
                    'read' => false,
                ]);
            }
        }

        return back();
    }

    public function storeComment(Request $request, Task $task)
    {
        $data = $request->validate(['body'=>'required|string']);
        $comment = $task->comments()->create([
            'user_id' => auth()->id(),
            'body' => $data['body'],
        ]);

        return back();
    }

    public function uploadFile(Request $request, Task $task)
    {
        $request->validate(['file'=>'required|file|max:5120']);
        $file = $request->file('file');
        $path = $file->store('task_files','public');

        $files = $task->files ?? [];
        $files[] = ['name' => $file->getClientOriginalName(), 'path' => $path];
        $task->update(['files' => $files]);

        return back();
    }
}
