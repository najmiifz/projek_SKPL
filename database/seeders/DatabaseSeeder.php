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
        $admin = User::firstOrCreate(
            ['email' => 'admin@sys.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('secret'),
                'role' => 'admin',
                'avatar' => 'https://i.pravatar.cc/150?u=admin@sys.com'
            ]
        );

        $pm = User::firstOrCreate(
            ['email' => 'budi@pm.com'],
            [
                'name' => 'Budi Project Manager',
                'password' => Hash::make('secret'),
                'role' => 'pm',
                'avatar' => 'https://i.pravatar.cc/150?u=budi@pm.com'
            ]
        );

        $dev = User::firstOrCreate(
            ['email' => 'siti@dev.com'],
            [
                'name' => 'Siti Developer',
                'password' => Hash::make('secret'),
                'role' => 'member',
                'avatar' => 'https://i.pravatar.cc/150?u=siti@dev.com'
            ]
        );

        $designer = User::firstOrCreate(
            ['email' => 'joko@des.com'],
            [
                'name' => 'Joko Designer',
                'password' => Hash::make('secret'),
                'role' => 'member',
                'avatar' => 'https://i.pravatar.cc/150?u=joko@des.com'
            ]
        );

        $tester = User::firstOrCreate(
            ['email' => 'ani@test.com'],
            [
                'name' => 'Ani Quality Assurance',
                'password' => Hash::make('secret'),
                'role' => 'member',
                'avatar' => 'https://i.pravatar.cc/150?u=ani@test.com'
            ]
        );

        // Create a project
        $project = Project::firstOrCreate(
            ['name' => 'Redesign Website Instansi'],
            [
                'description' => 'Pembaruan UI/UX dan migrasi database.',
                'start_date' => now()->subDays(20),
                'end_date' => now()->addDays(40),
                'status' => 'In Progress',
                'pm_id' => $pm->id,
            ]
        );

        // Create tasks
        Task::firstOrCreate(
            ['title' => 'Buat Mockup Homepage', 'project_id' => $project->id],
            [
                'description' => 'Desain mockup untuk halaman utama website',
                'assignee_id' => $designer->id,
                'priority' => 'High',
                'status' => 'Done',
                'progress' => 100,
                'start_date' => now()->subDays(15),
                'due_date' => now()->subDays(8),
                'validated_at' => now()->subDays(7),
                'files' => json_encode([['name' => 'mockup_v1.fig','path' => 'uploads/mockup_v1.fig']]),
            ]
        );

        Task::firstOrCreate(
            ['title' => 'Setup Database Schema', 'project_id' => $project->id],
            [
                'description' => 'Konfigurasi schema database untuk aplikasi baru',
                'assignee_id' => $dev->id,
                'priority' => 'High',
                'status' => 'In Progress',
                'progress' => 65,
                'start_date' => now()->subDays(10),
                'due_date' => now()->addDays(5),
                'files' => null,
            ]
        );

        Task::firstOrCreate(
            ['title' => 'Integrasi API Login', 'project_id' => $project->id],
            [
                'description' => 'Mengintegrasikan API login dengan sistem yang ada',
                'assignee_id' => $dev->id,
                'priority' => 'Medium',
                'status' => 'To Do',
                'progress' => 0,
                'start_date' => now()->addDays(3),
                'due_date' => now()->addDays(12),
                'files' => null,
            ]
        );

        Task::firstOrCreate(
            ['title' => 'Testing dan QA', 'project_id' => $project->id],
            [
                'description' => 'Melakukan comprehensive testing untuk seluruh fitur',
                'assignee_id' => $tester->id,
                'priority' => 'High',
                'status' => 'Review',
                'progress' => 75,
                'start_date' => now()->subDays(2),
                'due_date' => now()->addDays(8),
                'files' => null,
            ]
        );

        // Notifications
        NotificationItem::firstOrCreate(
            [
                'user_id' => $dev->id,
                'message' => 'Tugas baru diberikan kepada Anda: Setup Database Schema',
            ],
            ['read' => false]
        );

        NotificationItem::firstOrCreate(
            [
                'user_id' => $designer->id,
                'message' => 'Tugas Anda "Buat Mockup Homepage" telah divalidasi dan selesai oleh Project Manager.',
            ],
            ['read' => true]
        );
    }
}

