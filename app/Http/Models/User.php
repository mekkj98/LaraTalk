<?php

namespace App\Http\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'gender'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // friendship that I started
    function friendsOfMine()
    {
    return $this->belongsToMany(self::class, 'friends', 'sender', 'reciver')
        ->withPivot('status')->withPivot('updated_at')->withPivot('id');// ->wherePivot('status', '=', 1)
        
    }
    
    // friendship that I was invited to 
    function friendOf()
    {
    return $this->belongsToMany(self::class, 'friends', 'reciver', 'sender')
        ->withPivot('status')->withPivot('updated_at')->withPivot('id'); // ->wherePivot('status', '=', 1)
        
    }

    // accessor allowing you call $user->friends
    public function getFriendsAttribute()
    {
        if ( ! array_key_exists('friends', $this->relations)) $this->loadFriends();

        return $this->getRelation('friends');
    }

    protected function loadFriends()
    {
        if ( ! array_key_exists('friends', $this->relations))
        {
            $friends = $this->mergeFriends();

            $this->setRelation('friends', $friends);
        }
    }

    protected function mergeFriends()
    {
        return $this->friendsOfMine->merge($this->friendOf);
    }

    public function activity()
    {
        return $this->hasOne(Active::class, 'user_id');
    }
    
    public function setting()
    {
        return $this->hasOne(Setting::class, 'user_id');
    }
}
