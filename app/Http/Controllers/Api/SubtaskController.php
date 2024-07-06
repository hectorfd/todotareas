<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subtask;

class SubtaskController extends Controller
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
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:100',
            'task_id' => 'required|exists:tasks,id'
        ]);

        Subtask::create([
            'titulo' => $request->titulo,
            'task_id' => $request->task_id,
            'completado' => false,
        ]);

        return back();
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
    public function updateStatus(Subtask $subtask)
    {
        $subtask->completado = !$subtask->completado;
        $subtask->save();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subtask $subtask)
    {
        $subtask->delete();

        return back();
    }
}
