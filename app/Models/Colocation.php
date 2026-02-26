<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Colocation extends Model
{
    protected $fillable = [
        'name',
        'status_colocation',
        'token',
        'utilisateur_id',
        'created_at'
    ];

    
}
