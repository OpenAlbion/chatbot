<?php

namespace App\Http\Conversations;

use App\Services\ItemService;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use Illuminate\Support\Str;

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

            $server = Str::title($this->bot->userStorage()->get('server') ?: 'east');

            if (count($buttons) > 1) {
                $question = Question::create('Please select an item from the options provided')
                    ->addButtons($buttons);

                $this->bot->ask($question, function ($answer) use ($items, $server) {
                    $result = (new ItemService)->detail($server, $items[$answer->getValue()]['id']);
                    if (! empty($result)) {
                        $result = $items[$answer->getValue()]['name']." ($server Server) \n\n".$result;
                        $this->bot->reply($result, [
                            'parse_mode' => 'Markdown',
                        ]);
                    } else {
                        $this->bot->reply('No prices found for '.$items[$answer->getValue()]['name']." on the {$server} server.");
                    }

                    $this->bot->startConversation(new MarketPriceRepeatConversation);
                });
            } elseif (count($buttons) == 1) {
                $result = (new ItemService)->detail($server, $items[$answer->getValue()]['id']);
                if (! empty($result)) {
                    $result = $items[$answer->getValue()]['name']." ($server Server) \n\n".$result;
                    $this->bot->reply($result, [
                        'parse_mode' => 'Markdown',
                    ]);
                } else {
                    $this->bot->reply('No prices found for '.$items[$answer->getValue()]['name']." on the {$server} server.");
                }
            } else {
                $this->bot->reply('No items found for '.$answer->getText());
                $this->repeat();
            }
        });
    }
}
