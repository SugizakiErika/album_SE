<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Normal_event;
use App\Models\NormaleventUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class NormalEventPolicy
{
    use HandlesAuthorization;
    
    public function view(User $user, Normal_event $normal_event)
    {
       
        return $user->id == $normal_event->pivot->users_id;
  
    }
    
    public function update(User $user, Normal_event $normal_event)
    {
       
        return $user->id == $normal_event->pivot->users_id;
  
    }
    
    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
}
