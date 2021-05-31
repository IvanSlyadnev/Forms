<?php

namespace App\Http\Controllers\Webhook;

use App\Enums\QuestionType;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Monolog\Logger;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Notifications\FormOwnerNotification;
use App\Notifications\LeadNotification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TelegramController extends Controller
{
    public function  __invoke() {
        try {
            $updates = Telegram::getWebhookUpdates();
            $message = $updates->getMessage()->getText();
            $chat_id = $updates->getMessage()->getChat()->getId();
            $user = User::where('telegram_chat_id', $chat_id)->first();

            $members = $updates->getMessage()->getNewChatMembers();

            if ($updates->getMessage()->getLeftChatMember() && $updates->getMessage()->getFrom()->getIsBot()) {
                Telegram::deleteMessage([
                    'chat_id' => $chat_id,
                    'message_id' => $updates->getMessage()->getMessageId()
                ]);
            }
            if ($members) {
                $chat = Chat::where('telegram_chat_id', $chat_id)->first();
                foreach ($members as $member) {

                    if (!$chat->all_users->pluck('telegram_chat_id')->contains($member['id'])) {

                        Telegram::kickChatMember([
                            'chat_id' => $chat->telegram_chat_id,
                            'user_id' => $member['id']
                        ]);

                        Telegram::deleteMessage([
                            'chat_id' => $chat_id,
                            'message_id' => $updates->getMessage()->message_id
                        ]);
                    }
                }
            }

            if ($user && !$user->email) {
                $message = ['email' => $updates->getMessage()->getText()];
                $validate = Validator::make($message, [
                    'email' => 'email|unique:App\Models\User,email',
                ]);
                if (!$validate->fails()) {
                    $user->update($message);
                    Telegram::sendMessage([
                        'chat_id' => $chat_id,
                        'text' => 'Ваш email записан'
                    ]);
                } else {

                    Telegram::sendMessage([
                        'chat_id' => $chat_id,
                        'text' => implode("\n", $validate->errors()->all())
                    ]);
                    return;
                }
            }

            switch ($message) {
                case '/addgroup' :
                    $collection = collect(Telegram::getChatAdministrators(['chat_id' => $chat_id]));
                    if ($collection->contains(function ($value)
                    {
                        return ($value->getUser()->getId() == config('telegram.bots.mybot.id') && $value->can_invite_users && $value->can_restrict_members);
                    }))
                    {
                        $chat = Chat::updateOrCreate(['telegram_chat_id' => $chat_id],[ 'name' => $updates->getMessage()->getChat()->getTitle()]);
                        if ($chat->wasRecentlyCreated) {
                            Telegram::sendMessage([
                                'chat_id' => $chat_id,
                                'text' => "Чат добавлен"
                            ]);
                        } else {
                            Telegram::sendMessage([
                                'chat_id' => $chat_id,
                                'text' => "Чат обновлен"
                            ]);
                        }
                    }
                    else {
                        Telegram::sendMessage([
                            'chat_id' => $chat_id,
                            'text' => "Создать чат не удалось"
                        ]);
                    }
                    break;
                case '/chats' :
                    $user = User::where('telegram_chat_id', $updates->getMessage()->getFrom()->getId())->first();
                    $send_message = "";
                    foreach ($user->all_chats as $chat) {
                        $send_message .= $chat['chat']->invite_link. ' ';
                        if ($chat['chat']->name) $send_message .= $chat['chat']->name. ' ';
                        $send_message .= $chat['consists'] ? ' Да' : ' Нет';
                        $send_message .= "\n";
                    }
                    Telegram::sendMessage([
                        'chat_id' => $chat_id,
                        'text' => $send_message
                    ]);
                    break;
            }


        } catch (\Throwable $e) {
            logger()->info($e->getMessage());
        }
    }
}
