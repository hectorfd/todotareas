<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskList;
use Illuminate\Support\Facades\Auth;
use App\Models\Group;
use App\Models\User;
use App\Models\Invitation;
class DashboardController extends Controller
{
    public function index()
    {
        $taskLists = TaskList::where('user_id', Auth::id())->get();
        // $taskLists = TaskList::with(['tasks.subtasks'])->where('user_id', Auth::id())->get();

        return view('dashboard', compact('taskLists'));
        // return view('dashboard');
    }
    // public function index()
    // {
    // $taskLists = TaskList::where('user_id', Auth::id())
    //     ->with(['tasks' => function($query) {
    //         $query->where('completada', 0)->paginate(5);
    //     }])->get();

    // return view('dashboard', compact('taskLists'));
    // }

    public function showDashboard(Request $request)
{
    // Obtener el ID de la lista seleccionada desde la URL, si está presente
    $selectedTaskListId = $request->query('list', null);

    // Obtener solo las listas creadas por el usuario autenticado
    $taskLists = TaskList::where('user_id', Auth::id())->get();

    // Obtener los grupos creados por el usuario autenticado
    $groups = Group::where('user_id', Auth::id())->get();

    // Obtener las listas compartidas con el usuario autenticado
    $sharedTaskLists = TaskList::whereHas('group.members', function($query) {
        $query->where('user_id', Auth::id())->where('is_accepted', true);
    })->get();

    // Obtener todos los usuarios para invitarlos a un grupo
    $users = User::all();

    // Obtener las invitaciones pendientes
    $invitations = Invitation::where('invited_user_id', Auth::id())->with('inviter')->get();

    return view('dashboard', compact('taskLists', 'sharedTaskLists', 'groups', 'users', 'invitations', 'selectedTaskListId'));
}

    

    


    

}
