<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Solicitação de redefinição de senha')
            ->line('Você está recebendo este e-email pois recebemos uma solicitação de redefinição de senha para sua conta.')
            ->action('Resetar Senha', url('password/reset', $this->token))
            ->line('Se você não solicitou uma redefinição de senha para a sua conta, por favor, desconsidere este e-mail.');
    }
}