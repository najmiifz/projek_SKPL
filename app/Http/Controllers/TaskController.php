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
        $data = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assignee_id' => 'required|exists:users,id',
            'due_date' => 'nullable|date',
            'start_date' => 'nullable|date',
            'priority' => 'nullable|in:Low,Medium,High'
        ]);
        
        // Validate due_date doesn't exceed project end_date
        $project = Project::find($data['project_id']);
        if ($data['due_date'] && $project->end_date && \Carbon\Carbon::parse($data['due_date']) > \Carbon\Carbon::parse($project->end_date)) {
            return redirect()->back()->withErrors(['due_date' => 'Deadline tugas tidak boleh melampaui deadline proyek (' . $project->end_date . ')']);
        }
        
        $data['status'] = 'To Do';
        $data['progress'] = 0;
        $task = Task::create($data);

        // Send notification to assignee
        $assignee = \App\Models\User::find($data['assignee_id']);
        NotificationItem::create([
            'user_id' => $data['assignee_id'],
            'message' => "Tugas baru \"{$task->title}\" ditugaskan kepada Anda di proyek {$project->name}.",
            'read' => false,
        ]);

        return redirect()->route('projects.show', $data['project_id'])->with('success', 'Tugas berhasil ditambahkan!');
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
        // Prefer using the public disk (storage/app/public -> public/storage)
        if (file_exists(public_path('storage'))) {
            $path = $file->store('task_files','public');
        } else {
            // Fallback: store directly under public/uploads/task_files
            $uploadsDir = public_path('uploads/task_files');
            if (!file_exists($uploadsDir)) {
                mkdir($uploadsDir, 0755, true);
            }
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move($uploadsDir, $filename);
            $path = 'uploads/task_files/' . $filename;
        }

        $files = $task->files ?? [];
        $files[] = ['name' => $file->getClientOriginalName(), 'path' => $path];
        $task->update(['files' => $files]);

        return back()->with('status', 'File berhasil diupload.');
    }

    public function myTasks()
    {
        $user = Auth::user();
        $tasks = Task::where('assignee_id', $user->id)
                    ->with('project')
                    ->orderBy('created_at', 'desc')
                    ->get();
        
        return view('mytasks.index', compact('tasks'));
    }

    public function updateStatus(Request $request, Task $task)
    {
        $user = Auth::user();
        
        // Members can only submit for review (To Do/In Progress → Review)
        // Only PM can mark as Done (through validation)
        $allowedStatuses = ['To Do', 'In Progress', 'Review'];
        
        // Check if user is PM of this project
        $isPM = $user->role === 'admin' || ($task->project && $task->project->pm_id === $user->id);
        
        $request->validate([
            'status' => 'required|in:' . implode(',', $allowedStatuses)
        ]);

        // Prevent direct "Done" status update (only PM validation can do this)
        if ($request->status === 'Done') {
            return back()->with('error', 'Status "Done" hanya dapat ditetapkan melalui validasi PM!');
        }

        $oldStatus = $task->status;
        $task->update(['status' => $request->status]);

        // Notifikasi ke PM jika status berubah ke Review
        if ($request->status === 'Review' && $task->project && $task->project->pm_id) {
            $message = Auth::user()->name . " mengajukan tugas \"{$task->title}\" untuk divalidasi.";
            
            NotificationItem::create([
                'user_id' => $task->project->pm_id,
                'message' => $message,
                'read' => false,
            ]);
        }

        return back()->with('success', 'Status tugas berhasil diperbarui!');
    }

    public function validateTask(Request $request, Project $project, Task $task)
    {
        // Admin atau PM dapat memvalidasi hasil kerja
        $user = Auth::user();
        
        // Allow admin or the assigned PM
        $isPM = $user->role === 'admin' || ($user->role === 'pm' && $project->pm_id === $user->id);
        
        if (!$isPM) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk memvalidasi tugas ini.');
        }

        $request->validate([
            'approval' => 'required|in:approve,reject',
            'feedback' => 'nullable|string|max:500'
        ]);

        if ($request->approval === 'approve') {
            // Approve: change status to Done
            $task->update([
                'status' => 'Done',
                'validated_at' => now()
            ]);

            $message = "✓ Tugas \"{$task->title}\" telah disetujui dan selesai oleh Project Manager.";
        } else {
            // Reject: change status back to In Progress
            $task->update([
                'status' => 'In Progress',
                'validated_at' => null
            ]);

            $message = "✗ Tugas \"{$task->title}\" ditolak oleh Project Manager. ";
            if ($request->feedback) {
                $message .= "Feedback: " . $request->feedback;
            }
        }

        // Notifikasi ke assignee
        NotificationItem::create([
            'user_id' => $task->assignee_id,
            'message' => $message,
            'read' => false,
        ]);

        return back()->with('success', 'Validasi tugas berhasil!');
    }
}
