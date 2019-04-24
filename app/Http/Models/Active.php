<?php

namespace App\Http\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Active extends Model
{
   
    protected $table = "actives";

    protected $fillable = [
        'user_id', 'is_online'
    ];
}
