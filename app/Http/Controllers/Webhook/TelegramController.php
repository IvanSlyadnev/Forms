<?php

namespace App\Http\Controllers\Webhook;

use App\Enums\QuestionType;
use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Chat;
use App\Models\Form;
use App\Models\Lead;
use App\Models\Message;
use App\Models\Question;
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
            logger()->info('work');
            $updates = Telegram::getWebhookUpdates();
            $message = $updates->getMessage()->getText();
            $chat_id = $updates->getMessage()->getChat()->getId();

            $user = User::where('telegram_chat_id', $chat_id)->first();

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


            if ($message == '/addgroup')
            {
                $collection = collect(Telegram::getChatAdministrators(['chat_id' => $chat_id]));
                if ($collection->contains(function ($value)
                {
                    return ($value->getUser()->getId() == config('telegram.bots.mybot.id') && $value->can_invite_users && $value->can_restrict_members);
                }))
                {
                    $chat = Chat::updateOrCreate(['telegram_chat_id' => $chat_id]);

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
                }
        } catch (\Throwable $e) {
            logger()->info($e->getMessage());
        }
    }
}
