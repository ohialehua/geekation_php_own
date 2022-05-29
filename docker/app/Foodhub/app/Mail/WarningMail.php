<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WarningMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $admin_email;
    public $admin_tel;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $email, $admin_email, $admin_tel)
    {
        $this->name = $name;
        $this->email = $email;
        $this->admin_email = $admin_email;
        $this->admin_tel = $admin_tel;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->email)
        ->subject('アカウントを無効化しました。')
        ->view('mail.warning_mail')
        ->with(['name'=> $this->name, 'admin_email'=>$this->admin_email, 'admin_tel'=>$this->admin_tel]);
    }
}
