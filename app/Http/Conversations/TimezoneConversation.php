<?php

namespace App\Http\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;

class TimezoneConversation extends Conversation
{
    public function run()
    {
        $tz = $this->bot->userStorage()->get('tz');
        $this->bot->reply(__('messages.timezone_conversation.message', ['tz' => $tz]), [
            'parse_mode' => 'Markdown',
        ]);
    }
}
