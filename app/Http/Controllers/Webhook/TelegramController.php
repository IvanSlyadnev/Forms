<?php

namespace App\Http\Controllers\Webhook;

use App\Enums\QuestionType;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Message;
use App\Models\Question;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Monolog\Logger;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    public function __invoke()
    {
        
    }


    /*
    public function __invoke(){
        try {
            $updates = Telegram::getWebhookUpdates();
            $chat_id = $updates->getMessage()->getChat()->getId();
            $chat = Chat::updateOrCreate(['telegram_chat_id' => $chat_id]);
            if ($updates->getMessage()->getText() == 'где находится офис?') {
                Telegram::sendLocation([
                    'chat_id' => $chat_id,
                    'latitude' => 55.775586,
                    'longitude' =>37.586006
                ]);
            } else {
                Telegram::sendMessage([
                    'chat_id' => $chat_id,
                    'text' => $this->getMessage($updates)
                ]);
                if ($chat->currentMessage) {
                    switch ($chat->currentMessage->type) {
                        case QuestionType::select :
                        case QuestionType::radio :
                            if (!in_array($updates->getMessage()->getText(), $chat->currentMessage->values_array)) {
                                Telegram::sendMessage([
                                    'chat_id' => $chat_id,
                                    'text' => 'Ваш ответ не соответствует выбору'
                                ]);    
                                return;
                            }
                        break;    
                    }
                    $chat->messages()->syncWithoutDetaching([$chat->currentMessage->id => ['answer' => $updates->getMessage()->getText()]]);
                    $chat->currentMessage()->dissociate();
                }

                $question = $this->getRandomQuestion($chat_id);
                //$chat = Chat::where('telegram_chat_id', $chat_id)->first();
                //logger()->info($chat->messages);
                if ($question) {
                    $chat->currentMessage()->associate($question)->save();
                    //$chat->update(['current_message_id', $question->id]);
                    //$chat->current_message_id = $question_id;//$chat->save();
                    $chat->messages()->attach($question);//соединям $question

                    switch($question->type) {
                        case QuestionType::input :
                        case QuestionType::textarea :
                            Telegram::sendMessage([
                                'chat_id' => $chat_id,
                                'text' => $question->text
                            ]);
                        break;
                        case QuestionType::select : 
                        case QuestionType::radio :
                            $values = $question->values_array;

                            $reply_markup = Keyboard::make()->setResizeKeyboard(true)->setOneTimeKeyboard(true);
                            
                            foreach($values as $value) {
                                $reply_markup->row(
                                    Keyboard::button([
                                        'text' => $value,
                                    ])
                                );
                            }
                            Telegram::sendMessage([
                                'chat_id' => $chat_id,
                                'text' => $question->text,
                                'reply_markup' => $reply_markup
                            ]);
                        break; 
                    }
                    
                } else {
                    $resultMessage = "Вы ответили на все вопросы". "\n";
                    foreach ($chat->messages as $message) {
                        $resultMessage .= $message->text. ' - '. $message->pivot->answer."\n";
                    }
                    Telegram::sendMessage([
                        'chat_id' => $chat_id,
                        'text' => $resultMessage
                    ]);
                }
            }
        } catch (\Throwable $e) {
            logger()->info($e->getMessage());
        }

        return 'ok';
    }

    private function getMessage($updates) {
        switch($updates->getMessage()->getText()) {
            case 'Привет' :
                return 'Привет '.$updates->getMessage()->getChat()->getFirstName();
            case 'Как дела?' :
                return 'У меня хорошо, у тебя как?';
            case 'Что делаешь?' :
                return 'Отвечаю тебе на вопросы';
        }
        return 'Я пока не знаю что сказать';
    }

    private function getRandomQuestion ($chat_id) {
        return Message::whereDoesntHave('chats', function ($query) use ($chat_id) {
            $query->where('telegram_chat_id', $chat_id);
        })->inRandomOrder()->first();
    }*/


}

