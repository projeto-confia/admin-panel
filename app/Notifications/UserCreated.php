<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class UserCreated extends Notification
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Usuário criado')
            ->line('Por favor clique no botão abaixo para concluir o cadastro.')
            ->action('Concluir cadastro', $verificationUrl)
            ->line('Se você não solicitou ou foi informado da criação deste conta, por favor ignore este e-mail.');
    }

    private function verificationUrl(mixed $notifiable): string
    {
        return URL::temporarySignedRoute(
            'user.create-password',
            Carbon::now()->addSeconds(Config::get('auth.create-password.expire', 604800)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
