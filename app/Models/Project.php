<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name','description','start_date','end_date','status','pm_id'];

    public function pm()
    {
        return $this->belongsTo(User::class, 'pm_id');
    }

    public function pmUser()
    {
        return $this->belongsTo(User::class, 'pm_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
