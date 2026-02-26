<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Utilisateur;


class Membership extends Model
{
    protected $fillable = [
        'name',
        'role',
        'joined_at',
        'left_at',
        'is_active',
        'utilisateur_id',
        'colocation_id'
    ];

    
    
}
