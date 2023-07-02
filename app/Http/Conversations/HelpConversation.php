<?php

namespace App\Http\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use Illuminate\Support\Str;

class HelpConversation extends Conversation
{
    public function run()
    {
        $server = Str::title($this->bot->userStorage()->get('server') ?: 'east');

        $this->bot->reply(
            view('conversations.help', [
                'server' => $server,
            ])->render(),
            [
                'parse_mode' => 'Markdown',
            ]
        );
    }
}
