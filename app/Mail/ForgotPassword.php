<?php

namespace App\Mail;

use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\URL;

class ForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    private $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $date = new \DateTime();
        $now = $date->getTimestamp();
        $payload = array(
            "id" => Crypt::encryptString($this->user->id),
            "iat" => $now,
            "iss" => URL::to(''),
            "aud" => URL::to(''),
            "exp" => $now + (30 * 60)
        );

        $token = JWT::encode($payload, env("APP_KEY"));

        return $this->from(env("MAIL_FROM_ADDRESS"), env("MAIL_FROM_NAME"))
            ->view('forgot_password')
            ->subject("Forgot Password")
            ->with(["link" => env("APP_URL")."/verify/".$token]);
    }
}
