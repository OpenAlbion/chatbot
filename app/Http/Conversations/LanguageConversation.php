<?php

namespace App\Http\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;

class LanguageConversation extends Conversation
{
    public function run()
    {
        $lang = $this->bot->userStorage()->get('lang');
        if ($lang == 'mm') {
            $lang = 'မြန်မာ';
        } else {
            $lang = 'English';
        }
        $this->bot->reply(__('messages.language_conversation.message', ['lang' => $lang]), [
            'parse_mode' => 'Markdown',
        ]);
    }
}
