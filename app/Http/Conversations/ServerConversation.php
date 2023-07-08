<?php

namespace App\Http\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use Illuminate\Support\Str;

class ServerConversation extends Conversation
{
    public function run()
    {
        $server = $this->bot->userStorage()->get('server');
        $this->bot->reply(__('messages.server_conversation.message', ['server' => Str::title($server)]), [
            'parse_mode' => 'Markdown',
        ]);
    }
}
