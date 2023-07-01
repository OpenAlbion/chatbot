<?php

namespace App\Http\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class MarketPriceRepeatConversation extends Conversation
{
    public function run()
    {
        $question = Question::create('Do you want to search for another item?')
            ->addButtons([
                Button::create('Yes')
                    ->value('yes'),
                Button::create('No')
                    ->value('no')
            ]);
        $this->bot->ask($question, function ($answer) {
            if ($answer->getValue() == 'yes') {
                $this->bot->startConversation(new MarketPriceConversation());
            } else {
                $this->bot->reply('Sure');
            }
        });
    }
}
