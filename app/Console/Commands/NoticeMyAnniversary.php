<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailMyAnniversary;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\My_event;

class NoticeMyAnniversary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:notice_my_event_anniversary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '個人行事の記念日の通知';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data = Carbon::now()->format('m-d');
        $my_events = MY_event::where('start',$data)->where('category','anniversary')->get();
        //dd($my_events);
        foreach($my_events as $my_event){
         $name = 'pelican';
         $email = 'pelican01101996@gmail.com';
         $subject = "もうすぐ".$my_event->title."です！";
         }
         
         Mail::send(new MailMyAnniversary($name,$email,$subject));
    }
}
