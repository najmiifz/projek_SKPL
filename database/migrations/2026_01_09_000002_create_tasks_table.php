<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->string('title');
            $table->foreignId('assignee_id')->constrained('users')->onDelete('cascade');
            $table->string('priority')->default('Medium');
            $table->string('status')->default('To Do');
            $table->unsignedTinyInteger('progress')->default(0);
            $table->date('deadline')->nullable();
            $table->json('files')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
