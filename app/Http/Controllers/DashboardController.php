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
}
