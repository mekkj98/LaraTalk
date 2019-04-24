<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    
    protected $table = "settings";

    protected $fillable = [
        'user_id', 'hide_email', 'private'
    ];
}
