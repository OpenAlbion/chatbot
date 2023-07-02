<?php

namespace App\Http\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;

class AboutUsConversation extends Conversation
{
    public function run()
    {
        $this->bot->reply(view('conversations.about')->render(), [
            'parse_mode' => 'Markdown',
        ]);
    }
}
