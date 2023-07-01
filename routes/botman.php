<?php

use App\Http\Conversations\DownloadApplicationConversation;
use App\Http\Conversations\HelpConversation;
use App\Http\Conversations\MarketPriceConversation;
use App\Http\Conversations\MarketPriceItemConversation;
use App\Http\Conversations\MenuConversation;

$botman = resolve('botman');

$botman->hears('hi|hii|hello|/start', function ($bot) {
    $bot->startConversation(new MenuConversation());
});

$botman->hears('search', function ($bot) {
    $bot->startConversation(new MarketPriceConversation());
});

$botman->hears('search {itemName}', function ($bot, $itemName) {
    $userId = $bot->getUser()->getId();
    cache(["user.{$userId}.itemName" => $itemName], config(30 * 60));
    $bot->startConversation(new MarketPriceItemConversation());
});

$botman->hears('download', function ($bot) {
    $bot->startConversation(new DownloadApplicationConversation());
});

$botman->hears('help', function ($bot) {
    $bot->startConversation(new HelpConversation());
})->skipsConversation();

$botman->hears('stop', function ($bot) {
    $bot->reply('Sure');
})->stopsConversation();

$botman->fallback(function ($bot) {
    $bot->reply('Sorry, there is no response available for this message!');
    $bot->startConversation(new HelpConversation());
});
