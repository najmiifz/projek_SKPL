<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use App\Models\NotificationItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create users with roles and known passwords (password: secret)
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@sys.com',
            'password' => Hash::make('secret'),
            'role' => 'admin'
        ]);

        $pm = User::create([
            'name' => 'Budi Project Manager',
            'email' => 'budi@pm.com',
            'password' => Hash::make('secret'),
            'role' => 'pm'
        ]);

        $dev = User::create([
            'name' => 'Siti Developer',
            'email' => 'siti@dev.com',
            'password' => Hash::make('secret'),
            'role' => 'member'
        ]);

        $designer = User::create([
            'name' => 'Joko Designer',
            'email' => 'joko@des.com',
            'password' => Hash::make('secret'),
            'role' => 'member'
        ]);

        // Create a project
        $project = Project::create([
            'name' => 'Redesign Website Instansi',
            'description' => 'Pembaruan UI/UX dan migrasi database.',
            'start_date' => '2023-10-01',
            'end_date' => '2023-12-31',
            'status' => 'In Progress',
            'pm_id' => $pm->id,
        ]);

        // Create tasks
        Task::create([
            'project_id' => $project->id,
            'title' => 'Buat Mockup Homepage',
            'assignee_id' => $designer->id,
            'priority' => 'High',
            'status' => 'Done',
            'progress' => 100,
            'deadline' => '2023-10-15',
            'files' => json_encode([['name' => 'mockup_v1.fig','url' => '#']]),
        ]);

        Task::create([
            'project_id' => $project->id,
            'title' => 'Setup Database Schema',
            'assignee_id' => $dev->id,
            'priority' => 'High',
            'status' => 'In Progress',
            'progress' => 50,
            'deadline' => '2023-10-20',
            'files' => null,
        ]);

        Task::create([
            'project_id' => $project->id,
            'title' => 'Integrasi API Login',
            'assignee_id' => $dev->id,
            'priority' => 'Medium',
            'status' => 'To Do',
            'progress' => 0,
            'deadline' => '2023-10-25',
            'files' => null,
        ]);

        // Notifications
        NotificationItem::create(['user_id' => $dev->id, 'message' => 'Tugas baru diberikan kepada Anda: Setup Database Schema', 'read' => false]);
        NotificationItem::create(['user_id' => $pm->id, 'message' => 'Joko Designer menyelesaikan tugas: Buat Mockup Homepage', 'read' => true]);
    }
}

