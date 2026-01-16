<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->text('description')->nullable()->after('title');
            $table->date('start_date')->nullable()->after('deadline');
            $table->date('due_date')->nullable()->after('start_date');
            $table->timestamp('validated_at')->nullable()->after('progress');
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn(['description', 'start_date', 'due_date', 'validated_at']);
        });
    }
};
