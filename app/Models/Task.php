<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['project_id','title','description','assignee_id','priority','status','progress','deadline','start_date','due_date','files','validated_at'];

    protected $casts = [
        'files' => 'array',
        'start_date' => 'date',
        'due_date' => 'date',
        'validated_at' => 'datetime',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
