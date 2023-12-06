<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;


class UserRegistered extends Notification
{
    use Queueable;

    protected $token;
    /**
     * Create a new notification instance.
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $welcomeMessage = '¡Bienvenido a nuestra plataforma! Tu cuenta ha sido registrada en nuestro sistema. Para comenzar a utilizar nuestros servicios, por favor establece una contraseña segura.';

        $resetPasswordUrl = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Bienvenido a Mantenimientos SuiteServ Solutions')
            ->line('Estimado/a ' . $notifiable->nombre . ',')
            ->line($welcomeMessage)
            ->action('Establecer Contraseña', $resetPasswordUrl)
            ->line('Hemos seleccionado cuidadosamente a profesionales como tú para formar parte de nuestro equipo de trabajo y estamos emocionados de tenerte a bordo.')
            ->salutation('Atentamente, SuiteServ Solutions');
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
