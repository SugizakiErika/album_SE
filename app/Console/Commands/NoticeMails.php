<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNormal;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Normal_event;

class NoticeMails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:notice_normal_event';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '通常行事の通知';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
         $data = Carbon::now()->format('m-d');
         $normal_events = Normal_event::where('start',$data)->get();
         //dd($normal_events);
         foreach($normal_events as $normal_event){
         $name = 'pelican';
         $email = '';
         $subject = "もうすぐ".$normal_event->title."です！";
         $comment = $normal_event->comment;
         }
         
         Mail::send(new MailNormal($name,$email,$subject,$comment));
    }
}
