<?php

use App\Http\Conversations\AboutUsConversation;
use App\Http\Conversations\DownloadApplicationConversation;
use App\Http\Conversations\HelpConversation;
use App\Http\Conversations\MarketPriceItemConversation;
use App\Http\Conversations\ServerConversation;
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
        $bot->reply('The */server* command only accepts east or west as valid options.');
    }
});

$botman->hears('/about', function ($bot) {
    $bot->startConversation(new AboutUsConversation());
});

$botman->hears('/help', function ($bot) {
    $bot->startConversation(new HelpConversation());
})->skipsConversation();

$botman->hears('/stop', function ($bot) {
    $bot->reply('Sure');
})->stopsConversation();

$botman->fallback(function ($bot) {
    $bot->reply('Sorry, there is no response available for this message!');
    $bot->startConversation(new HelpConversation());
});
