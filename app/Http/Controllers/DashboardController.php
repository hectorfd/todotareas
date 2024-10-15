<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskList;
use Illuminate\Support\Facades\Auth;
use App\Models\Group;
use App\Models\User;
use App\Models\Task;
use App\Models\Invitation;
use Carbon\Carbon;
class DashboardController extends Controller
{
    public function index()
    {
        $taskLists = TaskList::where('user_id', Auth::id())->get();
      

        return view('dashboard', compact('taskLists'));
        
    }
    

    public function showDashboard(Request $request)
    {
        $selectedTaskListId = $request->query('list', null);
        $taskLists = TaskList::where('user_id', Auth::id())->get();
    
        $groups = Group::where('user_id', Auth::id())->get();
    
        $sharedTaskLists = TaskList::whereHas('group.members', function($query) {
            $query->where('user_id', Auth::id())->where('is_accepted', true);
        })->get();
    
        $users = User::all();
    
        $invitations = Invitation::where('invited_user_id', Auth::id())->with('inviter')->get();
    
        // Obtener las tareas vencidas del usuario logueado
        $expiredTasks = Task::where('user_id', Auth::id())
                            ->where('fecha_vencimiento', '<', Carbon::now())
                            ->where('completada', false)
                            ->get();
    
        return view('dashboard', compact('taskLists', 'sharedTaskLists', 'groups', 'users', 'invitations', 'selectedTaskListId', 'expiredTasks'));
    }


    

    


    

}
