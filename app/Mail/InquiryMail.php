<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$email,$comment)
    {
        $this->name = $name;
        $this->email = $email;
        $this->comment = $comment;
    }
    
    /**
     * Create a new message instance.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->email)
                    ->bcc(env('MAIL_USERNAME'))
                    ->subject('問い合わせ完了')
                    ->view('inquiry.send')
                    ->with([
                        'name' => $this->name,
                        'comment' => $this->comment,
                        ]);
    }
    
    
//     /**
//      * Get the message envelope.
//      *
//      * @return \Illuminate\Mail\Mailables\Envelope
//      */
//     public function envelope()
//     {
//         return new Envelope(
//             subject: 'Inquiry Mail',
//         );
//     }

//     /**
//      * Get the message content definition.
//      *
//      * @return \Illuminate\Mail\Mailables\Content
//      */
//     public function content()
//     {
//         return new Content(
//             view: 'view.name',
//         );
//     }

//     /**
//      * Get the attachments for the message.
//      *
//      * @return array
//      */
//     public function attachments()
//     {
//         return [];
//     }
 }
