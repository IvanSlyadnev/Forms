<?php
/*class Test {
    public function __invoke()
    {
        try {
            $updates = Telegram::getWebhookUpdates();
            $chat_id = $updates->getMessage()->getChat()->getId();
            $chat = Chat::updateOrCreate(['telegram_chat_id' => $chat_id]);
            $this->form = Form::where('name', $updates->getMessage()->getText())->first();
            if ($this->form != null) {
                logger()->info('Создание текущего лида');
                $lead = Lead::create(['form_id' => $this->form->id]);
                $chat->currentLead()->associate($lead)->save();
            }
            logger()->info('lid'.$chat->currentLead);
            if ($chat->currentLead) {
                if ( $chat->currentLead->currentQuestion) {    
                $chat->currentLead->answers()->create([
                    'value'=> $updates->getMessage()->getText(), 
                    'question_id' => $chat->currentLead->currentQuestion->id,
                    'lead_id' => $chat->currentLead->id
                ]);
                }
                //$chat->currentLead->currentQuestion()->dissociate();  
                $chat->currentLead->currentQuestion()->associate($this->getQuestion($chat->currentLead))->save(); 
                if ($chat->currentLead->currentQuestion) {
                    switch ($chat->currentLead->currentQuestion->type) 
                    {
                        case QuestionType::input :
                        case QuestionType::textarea :
                            Telegram::sendMessage([
                                'chat_id' => $chat_id,
                                'text' => $chat->currentLead->currentQuestion->question
                            ]);
                        break;  
                        case QuestionType::select : 
                        case QuestionType::radio :    
                            $reply_markup = Keyboard::make()->setResizeKeyboard(true)->setOneTimeKeyboard(true);
                            
                            foreach($chat->currentLead->currentQuestion->values_array as $value) {
                                $reply_markup->row(
                                    Keyboard::button([
                                        'text' => $value,
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
                    $resultMessage = "Вы ответили на все вопросы". "\n";
                    
                    foreach($chat->currentLead->answers as $answer) {
                        $resultMessage .= $answer->question->question.' - '.$answer->value."\n";
                    }
                    $chat->currentLead = false;
                    logger()->info($chat->currentLead);
                    Telegram::sendMessage([
                        'chat_id' => $chat_id,
                        'text' => $resultMessage
                    ]);
                    $this->outForm($chat_id);
                }
            } else {
                $this->outForm($chat_id);
            }
            //вывод вопросов
        
        } 
        catch(\Throwable $e) 
        {
            logger()->info($e->getMessage());
        }
    }


    private function getQuestion($lead) {
        return Question::where('form_id', $lead->form->id)
            ->whereDoesntHave('answers', function ($query) use($lead) {
                $query->where('lead_id', $lead->id);
            })->first();
    }

    private function outForm($chat_id) {
        $reply_markup = Keyboard::make()->setResizeKeyboard(true)->setOneTimeKeyboard(true);
                $forms = Form::where('is_public', 1)->get();
                foreach (Form::where('is_public', 1)->get() as $form) {
                    $reply_markup->row(
                        Keyboard::button([
                            'text' => $form->name,
                        ])
                    ); 
                }
                Telegram::sendMessage([
                    'chat_id' => $chat_id,
                    'text' => 'выбирай форму',
                    'reply_markup' => $reply_markup
                ]);
                
    }

}*/