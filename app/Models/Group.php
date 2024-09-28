<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $fillable = [
        'groupname', 
        'descripcion',
        'user_id',
    ];
    public function members()
    {
        return $this->hasMany(GroupMember::class);
    }

    public function groupMembers()
    {
        return $this->hasMany(GroupMember::class);
    }


    
}
