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
        // 1. Validasi format file yang diperbolehkan
        // mimes: jpeg, png, jpg (untuk gambar)
        // mimes: pdf, docx, zip (untuk dokumen/file)
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,pdf,docx,zip|max:10240' // Max 10MB
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();

        // 2. Tentukan folder penyimpanan berdasarkan tipe file
        // Gambar masuk ke folder 'images', sisanya masuk ke 'documents'
        $subFolder = in_array($extension, ['jpg', 'jpeg', 'png']) ? 'images' : 'documents';

        if (file_exists(public_path('storage'))) {
            // Simpan menggunakan disk public (rekomendasi Laravel)
            $path = $file->store("task_files/{$subFolder}", 'public');
        } else {
            // Fallback: simpan manual ke public/uploads
            $uploadsDir = public_path("uploads/task_files/{$subFolder}");
            if (!file_exists($uploadsDir)) {
                mkdir($uploadsDir, 0755, true);
            }
            $filename = time() . '_' . $originalName;
            $file->move($uploadsDir, $filename);
            $path = "uploads/task_files/{$subFolder}/" . $filename;
        }

        // 3. Update data file di database
        $files = $task->files ?? [];
        $files[] = [
            'name' => $originalName,
            'path' => $path,
            'type' => $subFolder, // Tambahan field untuk membedakan di tampilan
            'uploaded_at' => now()->toDateTimeString()
        ];

        $task->update(['files' => $files]);

        return back()->with('success', 'File ' . $originalName . ' berhasil diunggah.');
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
        $allowedStatuses = ['To Do', 'In Progress', 'Review'];

        $request->validate([
            'status' => 'required|in:' . implode(',', $allowedStatuses)
        ]);

        // LOGIKA PROGRESS OTOMATIS BERDASARKAN STATUS
        $progress = 0;
        if ($request->status === 'In Progress') {
            $progress = 50;
        } elseif ($request->status === 'Review') {
            $progress = 100;
        }

        $task->update([
            'status' => $request->status,
            'progress' => $progress // Update progress ke database
        ]);

        if ($request->status === 'Review' && $task->project && $task->project->pm_id) {
            NotificationItem::create([
                'user_id' => $task->project->pm_id,
                'message' => $user->name . " mengajukan tugas \"{$task->title}\" untuk divalidasi.",
                'read' => false,
            ]);
        }

        return back()->with('success', 'Status tugas berhasil diperbarui!');
    }

    public function validateTask(Request $request, Project $project, Task $task)
    {
        $user = Auth::user();
        $isPM = $user->role === 'admin' || ($user->role === 'pm' && $project->pm_id === $user->id);

        if (!$isPM) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'approval' => 'required|in:approve,reject',
            'feedback' => 'nullable|string|max:500'
        ]);

        if ($request->approval === 'approve') {
            $task->update([
                'status' => 'Done',
                'progress' => 100, // Tetap 100%
                'validated_at' => now()
            ]);
            $message = "✓ Tugas \"{$task->title}\" telah disetujui.";
        } else {
            // Jika ditolak, balikkan ke In Progress (50%) agar bisa diperbaiki
            $task->update([
                'status' => 'In Progress',
                'progress' => 50,
                'validated_at' => null
            ]);
            $message = "✗ Tugas \"{$task->title}\" ditolak. Feedback: " . $request->feedback;
        }

        NotificationItem::create([
            'user_id' => $task->assignee_id,
            'message' => $message,
            'read' => false,
        ]);

        return back()->with('success', 'Validasi tugas berhasil!');
    }
}
