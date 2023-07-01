<?php

namespace App\Http\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;

class HelpConversation extends Conversation
{
	public function run()
	{
		$this->bot->reply(
			view('conversations.help')->render(),
			[
				'parse_mode' => 'Markdown'
			]
		);
	}
}
