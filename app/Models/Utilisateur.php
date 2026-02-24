<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model
{
    protected $fillable = [
        'is_owner',
        'is_banned',
        'personne_id'
    ];
}
