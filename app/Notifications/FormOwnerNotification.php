<?php

namespace App\Notifications;

use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class FormOwnerNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $lead;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($lead)
    {
        $this->lead = $lead;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', TelegramChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        $message = new MailMessage();
        $message->subject('Форма ларавел');
        $message->line("На вашу форму ".$this->lead->form->name." ответил пользователь "
            .$this->lead->email);
        foreach ($this->lead->answers as $answer) {
            $message->line(new HtmlString("<b>".$answer->question->question."</b>"));
            $message->line($answer->value);
        }

        return $message;
    }

    public function toTelegram ($notifiable) {
        $telegramMessage = new TelegramMessage();

        $message = "На вашу форму ". $this->lead->form->name. " ответил пользователь " . $this->lead->email;

        foreach ($this->lead->answers as $answer) {
            $message .= "\n" . ' '. "*". $answer->question->question. "*" . ' ' .$answer->value;
        }
        return TelegramMessage::create()
            ->content($message);
    }

}
