<?php

use App\Http\Conversations\AboutUsConversation;
use App\Http\Conversations\DownloadApplicationConversation;
use App\Http\Conversations\HelpConversation;
use App\Http\Conversations\LanguageConversation;
use App\Http\Conversations\MarketPriceItemConversation;
use App\Http\Conversations\ServerConversation;
use App\Http\Conversations\TimezoneConversation;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

$botman = resolve('botman');

$botman->hears('hi|hii|hello|/start', function ($bot) {
    $bot->startConversation(new HelpConversation());
});

$botman->hears('/search {itemName}', function ($bot, $itemName) {
    $userId = $bot->getUser()->getId();
    cache(["user.{$userId}.itemName" => $itemName], config(30 * 60));
    $bot->startConversation(new MarketPriceItemConversation());
});

$botman->hears('/download', function ($bot) {
    $bot->startConversation(new DownloadApplicationConversation());
});

$botman->hears('/server {server}', function ($bot, $server) {
    $validator = Validator::make([
        'server' => Str::lower($server),
    ], [
        'server' => ['required', Rule::in(['east', 'west'])],
    ]);
    if ($validator->passes()) {
        $bot->userStorage()->save([
            'server' => $server,
        ]);

        $bot->startConversation(new ServerConversation());
    } else {
        $bot->reply(__('messages.server_conversation.error'));
    }
});

$botman->hears('/language {lang}', function ($bot, $lang) {
    $lang = Str::lower($lang);
    $validator = Validator::make([
        'lang' => $lang,
    ], [
        'lang' => ['required', Rule::in(['en', 'mm'])],
    ]);
    if ($validator->passes()) {
        $bot->userStorage()->save([
            'lang' => $lang,
        ]);

        App::setLocale($lang);

        $bot->startConversation(new LanguageConversation());
    } else {
        $bot->reply(__('messages.language_conversation.error'));
    }
});

$botman->hears('/timezone {tz}', function ($bot, $tz) {
    $validator = Validator::make([
        'tz' => $tz,
    ], [
        'tz' => ['required', 'timezone'],
    ]);
    if ($validator->passes()) {
        $bot->userStorage()->save([
            'tz' => $tz,
        ]);

        $bot->startConversation(new TimezoneConversation());
    } else {
        $bot->reply(__('messages.timezone_conversation.error'));
    }
});

$botman->hears('/about', function ($bot) {
    $bot->startConversation(new AboutUsConversation());
});

$botman->hears('/help', function ($bot) {
    $bot->startConversation(new HelpConversation());
})->skipsConversation();

$botman->hears('/stop', function ($bot) {
    $bot->reply(__('messages.sure'));
})->stopsConversation();

$botman->fallback(function ($bot) {
    $bot->reply(__('messages.fallback_conversation'));
    $bot->startConversation(new HelpConversation());
});
