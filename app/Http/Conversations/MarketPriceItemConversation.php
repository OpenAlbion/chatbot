<?php

namespace App\Http\Conversations;

use App\Services\ItemService;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class MarketPriceItemConversation extends Conversation
{
    public function run()
    {
        $userId = $this->bot->getUser()->getId();
        $itemName = trim(Str::before(cache("user.{$userId}.itemName"), '@'));
        $itemEnchantment = Str::after(cache("user.{$userId}.itemName"), '@');

        if ($itemName) {
            $items = (new ItemService)->search($itemName);

            $buttons = [];

            foreach ($items as $index => $item) {
                $buttons[] = Button::create($item['name'])
                    ->value($index);
            }

            $server = Str::title($this->bot->userStorage()->get('server') ?: 'east');

            if (count($buttons) > 1) {
                $question = Question::create('Please select an item from the options provided')
                    ->addButtons($buttons);
                $this->bot->ask($question, function ($answer) use ($items, $server, $itemEnchantment) {
                    if ($answer->isInteractiveMessageReply()) {
                        $result = (new ItemService)->detail($server, $items[$answer->getValue()]['id'], $itemEnchantment);
                        if (!empty($result)) {
                            $enchantment = in_array($itemEnchantment, range(1, 4))
                                ? " @{$itemEnchantment}"
                                : '';
                            $result = $items[$answer->getValue()]['name'] . "{$enchantment} ($server Server) \n\n" . $result;
                            $this->bot->reply($result, [
                                'parse_mode' => 'Markdown',
                            ]);
                        } else {
                            $this->bot->reply('No prices found for ' . $items[$answer->getValue()]['name'] . " on the {$server} server.");
                        }
                    } else {
                        $this->repeat();
                    }
                });
            } elseif (count($buttons) == 1) {
                $result = (new ItemService)->detail('west', $items[0]['id'], $itemEnchantment);
                if (!empty($result)) {
                    $enchantment = in_array($itemEnchantment, range(1, 4))
                        ? " @{$itemEnchantment}"
                        : '';
                    $result = $items[0]['name'] . "{$enchantment} ($server Server) \n\n" . $result;
                    $this->bot->reply($result, [
                        'parse_mode' => 'Markdown',
                    ]);
                } else {
                    $this->bot->reply('No prices found for ' . $items[0]['name'] . " on the {$server} server.");
                }
            } else {
                $this->bot->reply('No items found for ' . $itemName);
            }
        } else {
            $this->bot->reply('Sorry, unable to perform the search at the moment.');
        }

        Cache::forget("user.{$userId}.itemName");
    }
}
