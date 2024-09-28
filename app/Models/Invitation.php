<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;
    protected $fillable = [
        'group_id',
        'invited_user_id',
        'inviter_user_id',
        'role',
        'is_accepted',
    ];

    // Relación con grupos
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    // Relación con el usuario que es invitado
    public function invitedUser()
    {
        return $this->belongsTo(User::class, 'invited_user_id');
    }

    // Relación con el usuario que envía la invitación
    public function inviterUser()
    {
        return $this->belongsTo(User::class, 'inviter_user_id');
    }
    // En el modelo Invitation
    public function inviter()
    {
        return $this->belongsTo(User::class, 'inviter_user_id');
    }

}
