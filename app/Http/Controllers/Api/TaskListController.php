<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TaskList;
use Illuminate\Support\Facades\Auth;
use App\Models\Group;

class TaskListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $taskLists = TaskList::where('user_id', $user->id)->get(); 
        $groups = Group::where('user_id', $user->id)->get(); 

        return view('dashboard', compact('taskLists', 'groups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create()
    {
        return view('task_lists.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'listName' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
        ]);

        TaskList::create([
            'listName' => $request->listName,
            'descripcion' => $request->descripcion,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Lista creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function edit($id)
    {
    $taskList = TaskList::findOrFail($id);
    return view('task_lists.edit', compact('taskList'));
    }

    public function update(Request $request, $id)
    {
    $taskList = TaskList::findOrFail($id);

    $request->validate([
        'listName' => 'required|string|max:100',
        'descripcion' => 'nullable|string',
    ]);

    $taskList->update([
        'listName' => $request->listName,
        'descripcion' => $request->descripcion,
    ]);

    return redirect()->route('dashboard')->with('success', 'Lista actualizada exitosamente');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $taskList = TaskList::findOrFail($id);
        $taskList->delete();
    
        return redirect()->route('dashboard')->with('success', 'Lista eliminada exitosamente');
    }


    public function getTasks(TaskList $taskList)
    {
        // Retorna las tareas de la lista como JSON
        return response()->json([
            'tasks' => $taskList->tasks
        ]);
    }

    public function assignGroup(Request $request, $id)
    {
        $validatedData = $request->validate([
            'group_id' => 'required|exists:groups,id',
        ]);

        $taskList = TaskList::findOrFail($id);
        $taskList->group_id = $request->group_id;
        $taskList->save();

        return redirect()->back()->with('success', 'Lista de tareas asignada al grupo exitosamente');
    }

    
    
}
