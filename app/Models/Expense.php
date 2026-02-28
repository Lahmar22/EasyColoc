<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    protected $fillable = [
        'name',
        'titre',
        'amount',
        'expense_date',
        'colocation_id',
        'utilisateur_id',
        'category_id'
    ];
    
   
    
}
