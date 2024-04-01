<?php

namespace App\Policies;

use App\Models\User;
use App\Models\My_event;
use Illuminate\Auth\Access\HandlesAuthorization;

class MyEventPolicy
{
    use HandlesAuthorization;
    
    public function view(User $user, My_event $my_event)
    {
       
        return $user->id == $my_event->users_id;
  
    }
    
    public function delete(User $user, My_event $my_event)
    {
       
        return $user->id == $my_event->users_id;
  
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
