<?php

namespace App\Console\Commands;

use App\Jobs\ProcessChatUser;
use App\Models\User;
use App\Notifications\ChatNotification;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use TijsVerkoyen\CssToInlineStyles\Css\Processor;


class user_chats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:user_chats' ;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::all();

        $users->each(function ($user) {
            ProcessChatUser::dispatch($user);
        });
    }
}
