<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Normal_event extends Model
{
    use HasFactory;
    
    public function users()
    {
        return $this->belongsTonMany(User::class,'normal_event_users')->withPivot('notice','day_num');
    }
   
}
