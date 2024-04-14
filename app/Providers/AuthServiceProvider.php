<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        
        //他の人に見られないようにする設定
        'App\Models\Diary' => 'App\Policies\DiaryPolicy',
        'App\Models\My_event' => 'App\Policies\MyEventPolicy',
        'App\Models\Normal_event' => 'App\Policies\NormalEventPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        
        //管理者のみ閲覧可能にする設定
        Gate::define('isAdmin',function($user){

           return $user->role == 'administrator';
    
        });
        
        //ユーザーのみ
        Gate::define('isUser',function($user){
            
            return $user->role == NULL;
        });
    }
}
