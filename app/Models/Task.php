<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    

    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha_vencimiento',
        'completada',
        'user_id',
        'task_list_id',
    ];

    // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con la lista de tareas
    public function taskList()
    {
        return $this->belongsTo(TaskList::class);
    }
    public function tasks()
    {
    return $this->hasMany(Task::class);
    }

    public function subtasks()
    {
        return $this->hasMany(Subtask::class);
    }
    

}
