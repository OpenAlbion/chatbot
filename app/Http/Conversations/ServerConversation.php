<?php

namespace App\Http\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;

class ServerConversation extends Conversation
{
    public function run()
    {
        $server = $this->bot->userStorage()->get('server');
        $this->bot->reply("Your server has been set to *{$server}*");
    }
}
