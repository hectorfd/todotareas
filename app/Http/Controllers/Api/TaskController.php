<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\TaskList;
use Illuminate\Support\Facades\Auth;
class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Task::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create($taskListId)
    {
        $taskList = TaskList::findOrFail($taskListId);
        return view('tasks.create', compact('taskList'));
    }

    public function store(Request $request, $taskListId)
    {
        $request->validate([
            'titulo' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'fecha_vencimiento' => 'nullable|date',
            'completada' => 'boolean',
        ]);

        $taskList = TaskList::findOrFail($taskListId);

        $task = new Task();
        $task->titulo = $request->titulo;
        $task->descripcion = $request->descripcion;
        $task->fecha_vencimiento = $request->fecha_vencimiento;
        $task->completada = $request->completada ?? false;
        $task->user_id = Auth::id();
        $task->task_list_id = $taskList->id;
        $task->save();

        return redirect()->route('dashboard')->with('success', 'Tarea creada con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Task::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     $task = Task::findOrFail($id);
    //     $task->update($request->all());
    //     return response()->json($task, 200);
    // }
    public function update(Request $request, Task $task)
    {
    $task->update($request->all());
    return redirect()->back()->with('success', 'Tarea actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     Task::findOrFail($id)->delete();
    //     return response()->json(null, 204);
    // }
    public function destroy(Task $task)
    {
    $task->delete();
    return redirect()->back()->with('success', 'Tarea eliminada correctamente.');
    }
    public function updateStatus(Request $request, $id)
    {
    $task = Task::findOrFail($id);
    $task->completada = $request->has('completada') ? 1 : 0;
    $task->save();

    return redirect()->route('dashboard');
    }


    public function completed($taskListId)
    {
    $taskList = TaskList::findOrFail($taskListId);
    $completedTasks = $taskList->tasks()->where('completada', 1)->get();

    return view('tasks.completed', compact('taskList', 'completedTasks'));
    }


}
