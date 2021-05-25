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
    public function __invoke()
    {
        try {
            $updates = Telegram::getWebhookUpdates();
            $chat_id = $updates->getMessage()->getChat()->getId();
            $chat = Chat::updateOrCreate(['telegram_chat_id' => $chat_id]);

            if ($chat->user && !$chat->user->email) {
                $message = ['email' => $updates->getMessage()->getText()];
                $validate = Validator::make($message, [
                    'email' => 'email|unique:App\Models\User,email',
                ]);
                if (!$validate->fails()) {
                    $chat->user->update($message);
                    $chat->update($message);
                } else {

                    Telegram::sendMessage([
                        'chat_id' => $chat_id,
                        'text' => implode("\n", $validate->errors()->all())
                    ]);
                    return;
                }
            }

            if ($chat->currentLead && !$chat->email) {
                $chat->update(['email' => $updates->getMessage()->getText()]);
            }
            if (!$chat->currentLead) {

                if ($updates->getCallbackQuery()) {
                    //$lead = Lead::create(['form_id' => $form->id]);
                    $lead = Lead::create(['form_id' => Form::where('name', $updates->callback_query->data)->first()->id]);
                    $chat->currentLead()->associate($lead)->save();
                }
                else {
                    $this->outForm($chat_id);
                }
            }
            if ($chat->currentLead) {
                $chat->currentLead()->update(['email' => $chat->email]);
                if (!$chat->email) {
                    Telegram::sendMessage([
                        'chat_id' => $chat_id,
                        'text' => 'Отправьте свой email'
                    ]);
                    return;
                }
                if ($chat->currentLead->currentQuestion) {
                    $values = $chat->currentLead->currentQuestion->values_array;
                    switch ($chat->currentLead->currentQuestion->type) {
                        case QuestionType::input:
                        case QuestionType::textarea:
                            if ($updates->getMessage()->getText()) {
                                $answer = $updates->getMessage()->getText();
                            }
                            break;
                        case QuestionType::select:
                        case QuestionType::radio:
                            if ($updates->getCallbackQuery()) {
                                $answer = $updates->callback_query->data;
                            }
                            break;
                        case QuestionType::file:
                            if ($updates->getMessage()->getPhoto()) {
                                $answer = $this->getImage($updates);
                            }
                            break;
                        default :
                            return;
                    }
                    if (isset($answer)) {
                        if (in_array($answer, $values) || $chat->currentLead->currentQuestion->values == null) {
                            $chat->currentLead->answers()->create([
                                'value' => $answer,
                                'question_id' => $chat->currentLead->currentQuestion->id,
                                //'lead_id' => $chat->currentLead->id
                            ]);
                        } else {
                            Telegram::sendMessage([
                                'chat_id' => $chat_id,
                                'text' => 'Выберите ответ из предложенных'
                            ]);
                        }
                    } else {
                        Telegram::sendMessage([
                            'chat_id' => $chat_id,
                            'text' => 'Нельзя так'
                        ]);
                    }

                }
                $chat->currentLead->currentQuestion()->associate($this->getQuestion($chat->currentLead))->save();
                if ($chat->currentLead->currentQuestion) {
                    switch ($chat->currentLead->currentQuestion->type) {
                        case QuestionType::input:
                        case QuestionType::textarea:
                        case QuestionType::file:
                            Telegram::sendMessage([
                                'chat_id' => $chat_id,
                                'text' => $chat->currentLead->currentQuestion->question
                            ]);
                            break;
                        case QuestionType::select:
                        case QuestionType::radio:
                            $reply_markup = Keyboard::make()->inline();

                            foreach ($chat->currentLead->currentQuestion->values_array as $value) {
                                $reply_markup->row(
                                    Keyboard::button([
                                        'text' => $value,
                                        'callback_data' => $value
                                    ])
                                );
                            }
                            Telegram::sendMessage([
                                'chat_id' => $chat_id,
                                'text' => $chat->currentLead->currentQuestion->question,
                                'reply_markup' => $reply_markup
                            ]);
                        break;
                    }
                } else {
                    $resultMessage = "Вы ответили на все вопросы" . "\n";

                    foreach ($chat->currentLead->answers as $answer) {
                        $resultMessage .= ($answer->question->type == QuestionType::file)
                            ? asset(Storage::url($answer->value)) : $answer->value;
                    }
                    Telegram::sendMessage([
                        'chat_id' => $chat_id,
                        'text' => $resultMessage
                    ]);
                    $this->outForm($chat_id);
                    $chat->currentLead->form->user->notify(new FormOwnerNotification($chat->currentLead));
                    $chat->currentLead->notify(new LeadNotification());
                    $chat->currentLead()->dissociate()->save();

                }
            }
            //вывод вопросов
        } catch (\Throwable $e) {
            logger()->info($e->getMessage());
        }
    }

    private function getImage($updates) {
        $path = Telegram::getFile(['file_id' => $updates->getMessage()->getPhoto()->first()['file_id']])->file_path;
        $expansion = explode('.', $path)[1];
        $name = Str::random(10).'.'.$expansion;
        $link = "https://api.telegram.org/file/bot".config('telegram.bots.mybot.token').'/'.$path;
        Storage::put('/public/files/'.$name, file_get_contents($link));
        return "files/".$name;
    }

    private function getQuestion($lead)
    {
        return Question::where('form_id', $lead->form->id)
            ->whereDoesntHave('answers', function ($query) use ($lead) {
                $query->where('lead_id', $lead->id);
            })->first();
    }

    private function outForm($chat_id)
    {
        $reply_markup = Keyboard::make()->inline();
        $forms = Form::where('is_public', 1);
        if ($forms->count()) {
            foreach ($forms->get() as $form) {
                $reply_markup->row(
                    Keyboard::button([
                        'text' => $form->name,
                        'callback_data' => $form->name
                    ])
                );
            }
            Telegram::sendMessage([
                'chat_id' => $chat_id,
                'text' => 'выбирай форму',
                'reply_markup' => $reply_markup
            ]);
        } else {
            Telegram::sendMessage([
                'chat_id' => $chat_id,
                'text' => 'Форм нет',
            ]);
        }
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
