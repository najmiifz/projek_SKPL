<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Task;
use App\Models\NotificationItem;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $projects = Project::count();
        $activeTasks = Task::where('status','In Progress')->count();
        $pendingReview = Task::where('status','Review')->count();
        $notifications = NotificationItem::where('user_id', $user->id)->orderBy('created_at','desc')->get();

        return view('dashboard', compact('user','projects','activeTasks','pendingReview','notifications'));
    }

    public function adminDashboard()
    {
        // Dashboard Global untuk Admin
        $totalUsers = \App\Models\User::count();
        $totalProjects = Project::count();
        $totalTasks = Task::count();
        $activeProjects = Project::where('status', '!=', 'Done')->count();
        
        $recentActivities = Task::with('assignee', 'project')
                               ->orderBy('updated_at', 'desc')
                               ->limit(10)
                               ->get();

        $projectProgress = Project::selectRaw('status, COUNT(*) as count')
                                 ->groupBy('status')
                                 ->get()
                                 ->pluck('count', 'status');

        return view('admin.dashboard', compact(
            'totalUsers', 'totalProjects', 'totalTasks', 'activeProjects',
            'recentActivities', 'projectProgress'
        ));
    }

    public function logActivities()
    {
        // Log semua aktivitas sistem
        $activities = collect([]);
        
        // Get task updates
        $taskActivities = Task::with('assignee', 'project')
                             ->orderBy('updated_at', 'desc')
                             ->get()
                             ->map(function($task) {
                                 return [
                                     'id' => $task->id,
                                     'type' => 'task_update',
                                     'user' => $task->assignee->name ?? 'Unknown',
                                     'user_avatar' => $task->assignee->avatar ?? 'https://i.pravatar.cc/40',
                                     'user_role' => ucfirst($task->assignee->role ?? 'Member'),
                                     'action' => "Updated task: {$task->title}",
                                     'title' => $task->title,
                                     'status' => $task->status,
                                     'progress' => $task->progress ?? 0,
                                     'project' => $task->project->name ?? 'Unknown',
                                     'project_id' => $task->project_id,
                                     'timestamp' => $task->updated_at,
                                     'link' => route('tasks.show', $task->id),
                                 ];
                             });

        // Get project updates  
        $projectActivities = Project::with('pmUser')
                                   ->orderBy('updated_at', 'desc')
                                   ->get()
                                   ->map(function($project) {
                                       return [
                                           'id' => $project->id,
                                           'type' => 'project_update',
                                           'user' => $project->pmUser->name ?? 'Unknown',
                                           'user_avatar' => $project->pmUser->avatar ?? 'https://i.pravatar.cc/40',
                                           'user_role' => 'Project Manager',
                                           'action' => "Updated project: {$project->name}",
                                           'title' => $project->name,
                                           'status' => $project->status,
                                           'project' => $project->name,
                                           'project_id' => $project->id,
                                           'timestamp' => $project->updated_at,
                                           'link' => route('projects.show', $project->id),
                                       ];
                                   });

        $activities = $taskActivities->concat($projectActivities)
                                   ->sortByDesc('timestamp')
                                   ->take(50);

        return view('admin.logs', compact('activities'));
    }

    public function notifications()
    {
        $user = Auth::user();
        $notifications = NotificationItem::where('user_id', $user->id)
                                        ->orderBy('created_at', 'desc')
                                        ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead(NotificationItem $notification)
    {
        if ($notification->user_id === Auth::id()) {
            $notification->update(['read' => true]);
        }

        return back();
    }
    
    public function markAllAsRead()
    {
        NotificationItem::where('user_id', Auth::id())
                       ->where('read', false)
                       ->update(['read' => true]);

        return back()->with('status', 'Semua notifikasi telah ditandai dibaca');
    }
}
