<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = [
        'email',
        'token',
        'colocation_id',
        'utilisateur_id',
        'status'
    ];
}
