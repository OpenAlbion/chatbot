<?php

namespace App\Http\Conversations;

use App\Services\ItemService;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use Illuminate\Support\Facades\App;
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
                $question = Question::create(__('messages.item_conversation.question'))
                    ->addButtons($buttons);
                $this->bot->ask($question, function ($answer) use ($items, $server, $itemEnchantment) {
                    if ($answer->isInteractiveMessageReply()) {
                        $lang = $this->bot->userStorage()?->get('lang') ?: 'en';
                        $tz = $this->bot->userStorage()?->get('tz') ?: 'UTC';
                        App::setLocale($lang);

                        $result = (new ItemService)->detail($server, $items[$answer->getValue()]['id'], $itemEnchantment, $tz);
                        if (!empty($result)) {
                            $enchantment = in_array($itemEnchantment, range(1, 4))
                                ? " @{$itemEnchantment}"
                                : '';
                            $result = $items[$answer->getValue()]['name'] . "{$enchantment} ($server Server) | $tz \n\n" . $result;
                            $this->bot->reply($result, [
                                'parse_mode' => 'Markdown',
                            ]);
                        } else {
                            $this->bot->reply(__('messages.item_conversation.no_prices', [
                                'name' => $items[$answer->getValue()]['name'],
                                'server' => $server
                            ]));
                        }
                    } else {
                        $this->repeat();
                    }
                });
            } elseif (count($buttons) == 1) {
                $tz = $this->bot->userStorage()?->get('tz') ?: 'UTC';
                $result = (new ItemService)->detail('west', $items[0]['id'], $itemEnchantment, $tz);
                if (!empty($result)) {
                    $enchantment = in_array($itemEnchantment, range(1, 4))
                        ? " @{$itemEnchantment}"
                        : '';
                    $result = $items[0]['name'] . "{$enchantment} ($server Server) | $tz \n\n" . $result;
                    $this->bot->reply($result, [
                        'parse_mode' => 'Markdown',
                    ]);
                } else {
                    $this->bot->reply(__('messages.item_conversation.no_prices', [
                        'name' => $items[0]['name'],
                        'server' => $server
                    ]));
                }
            } else {
                $this->bot->reply(__('messages.item_conversation.no_items', [
                    'name' => $itemName,
                ]));
            }
        } else {
            $this->bot->reply(__('messages.item_conversation.sorry'));
        }

        Cache::forget("user.{$userId}.itemName");
    }
}
