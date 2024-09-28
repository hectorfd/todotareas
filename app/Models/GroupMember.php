<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupMember extends Model
{
    use HasFactory;
    protected $fillable = [
        'group_id',
        'user_id',
        'is_accepted',
        'role',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Relación con el usuario
     * Un miembro es un usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
