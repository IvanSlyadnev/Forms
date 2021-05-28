<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\ChatNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessChatUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    private $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $chats = $this->user->all_chats;
        if ($chats->contains(function ($value) {
            return !$value['consists'];
        })) {
            $this->user->notify(new ChatNotification(
                $chats->filter(function ($value) {
                    return !$value['consists'];
                })->map(function ($value) {
                    return [
                        'name' => $value['chat']->name,
                        'url' => $value['chat']->invite_link
                    ];
                })
            ));
        }
    }
}
