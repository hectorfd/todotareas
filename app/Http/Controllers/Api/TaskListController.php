<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TaskList;
use Illuminate\Support\Facades\Auth;

class TaskListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    
}
