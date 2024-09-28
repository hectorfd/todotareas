<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Invitation;
class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $groups = Group::all();
        return back();
        // return view('group.index', compact('groups'));
    }

    public function create()
    {
        return view('group.create');  
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'groupname' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
        ]);

        $validatedData['user_id'] = auth()->id(); 

        Group::create($validatedData);

        return redirect()->route('groups.index')->with('success', 'Grupo creado exitosamente');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $group = Group::findOrFail($id);
        return view('group.show', compact('group'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $group = Group::findOrFail($id);

        $validatedData = $request->validate([
            'groupname' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
        ]);

        $group->update($validatedData);

        return redirect()->route('groups.index')->with('success', 'Grupo actualizado exitosamente');
   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $group = Group::findOrFail($id);
        $group->delete();

        return redirect()->route('groups.index')->with('success', 'Grupo eliminado exitosamente');
   
    }


    public function inviteUser(Request $request, Group $group)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:admin,write,read',
        ]);

        // Crear invitación
        Invitation::create([
            'group_id' => $group->id,
            'invited_user_id' => $request->user_id,
            'inviter_user_id' => auth()->id(),
            'role' => $request->role,
        ]);

        return back()->with('success', 'Invitación enviada.');
    }

}
