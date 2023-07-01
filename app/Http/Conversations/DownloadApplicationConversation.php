<?php

namespace App\Http\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;


class DownloadApplicationConversation extends Conversation
{
    public function run()
    {
        $this->bot->reply(view('conversations.downloadApplication')->render(), [
            'parse_mode' => 'Markdown'
        ]);
    }
}
