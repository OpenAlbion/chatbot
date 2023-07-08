<?php

namespace App\Http\Middleware;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Interfaces\Middleware\Heard;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use Illuminate\Support\Facades\App;

class BotmanHeard implements Heard
{
    public function heard(IncomingMessage $message, $next, BotMan $bot)
    {
        $lang = $bot->userStorage()?->get('lang') ?: 'en';
        App::setLocale($lang);
        return $next($message);
    }
}
