<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements MustVerifyEmail //implementsの追加
{
    use HasApiTokens, HasFactory, Notifiable;
    
    // public function diary()
    // {
    //     return $this->belongsTo(diary::class);
    // }
    
    public function normal_events()
    {
        return $this->belongsToMany(Normal_event::class,'normal_event_users')
        ->withPivot('notice','day_num');
    }
    
    
    // public function my_event()
    // {
    //     return $this->belongsTo(my_event::class);
    // }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    
}
