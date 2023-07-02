<?php

namespace App\Http\Conversations;

use App\Services\ItemService;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class MarketPriceItemConversation extends Conversation
{
    public function run()
    {
        $userId = $this->bot->getUser()->getId();
        $itemName = cache("user.{$userId}.itemName");

        if ($itemName) {
            $items = (new ItemService)->search($itemName);

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
                    if (!empty($result)) {
                        $result = $items[$answer->getValue()]['name'] . " prices for the West server. \n\n" . $result;
                        $this->bot->reply($result, [
                            'parse_mode' => 'Markdown',
                        ]);
                    } else {
                        $this->bot->reply('No prices found for ' . $items[$answer->getValue()]['name'] . ' on the West server.');
                    }

                    $result = (new ItemService)->detail('east', $items[$answer->getValue()]['id']);
                    if (!empty($result)) {
                        $result = $items[$answer->getValue()]['name'] . " prices for the East server. \n\n" . $result;
                        $this->bot->reply($result, [
                            'parse_mode' => 'Markdown',
                        ]);
                    } else {
                        $this->bot->reply('No prices found for ' . $items[$answer->getValue()]['name'] . ' on the East server.');
                    }
                });
            } elseif (count($buttons) == 1) {
                $result = (new ItemService)->detail('west', $items[0]['id']);
                if (!empty($result)) {
                    $result = $items[0]['name'] . " prices for the West server. \n\n" . $result;
                    $this->bot->reply($result, [
                        'parse_mode' => 'Markdown',
                    ]);
                } else {
                    $this->bot->reply('No prices found for ' . $items[0]['name'] . ' on the West server.');
                }

                $result = (new ItemService)->detail('east', $items[0]['id']);
                if (!empty($result)) {
                    $result = $items[0]['name'] . " prices for the East server. \n\n" . $result;
                    $this->bot->reply($result, [
                        'parse_mode' => 'Markdown',
                    ]);
                } else {
                    $this->bot->reply('No prices found for ' . $items[0]['name'] . ' on the East server.');
                }
            } else {
                $this->bot->reply('No items found for ' . $itemName);
            }
        } else {
            $this->bot->reply('Sorry, unable to perform the search at the moment.');
        }
    }
}
