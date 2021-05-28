<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class ChatNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    private $chats;
    public function __construct($chats)
    {
        $this->chats = $chats;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable) {

        $message = "";
        foreach ($this->chats as $chat) {
            $message .= $chat['name']. ' : ';
            $message .= $chat['url'];
            $message .= "\n";
        }

        return TelegramMessage::create()
            ->content('Вам позволено, но вы не состоите в следующих чатах'."\n".$message);
    }

}
