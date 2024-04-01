<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Diary;
use App\Models\Diary_image;

use Illuminate\Auth\Access\HandlesAuthorization;

class DiaryPolicy
{
    use HandlesAuthorization;
    
    public function view(User $user, Diary $diary)
    {
       
        return $user->id == $diary->users_id;
  
    }
    
    public function create(User $user, Diary $diary)
    {
       
        return $user->id == $diary->users_id;
  
    }
    
    public function delete(User $user, Diary $diary)
    {
       
        return $user->id == $diary->users_id;
  
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
