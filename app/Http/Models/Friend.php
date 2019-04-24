<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    
    protected $table = "friends";

    protected $fillable = [
        'sender', 'reciver', 'status', 'message'
    ];
}
