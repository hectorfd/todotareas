<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GroupMember;
use App\Models\Invitation;
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

}
