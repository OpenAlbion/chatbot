<?php

namespace App\Http\Conversations;

use App\Services\ItemService;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class MarketPriceConversation extends Conversation
{
    public function run()
    {
        $this->ask('Please enter the name of the item you would like to search for', function ($answer) {
            $items = (new ItemService)->search($answer->getText());

            $buttons = [];

            foreach ($items as $index => $item) {
                $buttons[] = Button::create($item['name'])
                    ->value($index);
            }

            if (count($buttons) > 1) {
                $question = Question::create('Please select an item from the options provided')
                    ->addButtons($buttons);
                $this->bot->ask($question, function ($answer) use ($items) {
                    $result = (new ItemService)->detail('west', $items[$answer->getValue()]['id']);
                    if (! empty($result)) {
                        $this->bot->reply($items[$answer->getValue()]['name'].' prices for the West server.');
                        $this->bot->reply($result, [
                            'parse_mode' => 'Markdown',
                        ]);
                    } else {
                        $this->bot->reply('No prices found for '.$items[$answer->getValue()]['name'].' on the West server.');
                    }

                    $result = (new ItemService)->detail('east', $items[$answer->getValue()]['id']);
                    if (! empty($result)) {
                        $this->bot->reply($items[$answer->getValue()]['name'].' prices for the East server.');
                        $this->bot->reply($result, [
                            'parse_mode' => 'Markdown',
                        ]);
                    } else {
                        $this->bot->reply('No prices found for '.$items[$answer->getValue()]['name'].' on the East server.');
                    }

                    $this->bot->startConversation(new MarketPriceRepeatConversation);
                });
            } elseif (count($buttons) == 1) {
                $result = (new ItemService)->detail('west', $items[0]['id']);
                if (! empty($result)) {
                    $this->bot->reply($items[0]['name'].' prices for the West server.');
                    $this->bot->reply($result, [
                        'parse_mode' => 'Markdown',
                    ]);
                } else {
                    $this->bot->reply('No prices found for '.$items[0]['name'].' on the West server.');
                }

                $result = (new ItemService)->detail('east', $items[0]['id']);
                if (! empty($result)) {
                    $this->bot->reply($items[0]['name'].' prices for the East server.');
                    $this->bot->reply($result, [
                        'parse_mode' => 'Markdown',
                    ]);
                } else {
                    $this->bot->reply('No prices found for '.$items[0]['name'].' on the East server.');
                }
            } else {
                $this->bot->reply('No items found for '.$answer->getText());
                $this->repeat();
            }
        });
    }
}
