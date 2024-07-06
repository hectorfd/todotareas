<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtask extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'completado', 'task_id'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
