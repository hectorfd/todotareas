<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GroupMember;
use App\Models\Invitation;
use App\Models\Task;
use Carbon\Carbon;
class InvitationController extends Controller
{
    public function respond(Request $request, Invitation $invitation)
    {
        if ($request->response == 'accepted') {
            // Mover a group_members
            GroupMember::create([
                'group_id' => $invitation->group_id,
                'user_id' => $invitation->invited_user_id,
                'role' => $invitation->role,
                'is_accepted' => true,
            ]);
        }
        // Eliminar la invitación, sea aceptada o rechazada
        $invitation->delete();

        return back()->with('success', 'Respuesta enviada.');
    }

    public function showNotifications()
    {
        $user = auth()->user();

        $invitations = Invitation::where('invited_user_id', $user->id)->get();
        $expiredTasks = Task::where('user_id', $user->id)
                            ->where('fecha_vencimiento', '<', Carbon::now())
                            ->where('completada', false)
                            ->get();

        return view('notifications', compact('invitations', 'expiredTasks'));
    }

}
