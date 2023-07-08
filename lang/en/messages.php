<?php

return [
    'about' => 'OpenAlbion is a free and open-source project that provides Albion Online data and an API for developers to create their own applications. Our mission is to empower the Albion Online community by offering access to valuable game data, allowing developers to build innovative tools and services. Visit [openalbion.com](https://openalbion.com) for more information.',
    'download' => [
        'intro' => 'OpenAlbion Weaponry is an application where you can conveniently check weapons, armors, mounts, and other items in one place.',
        'link' => 'You can download OpenAlbion Weaponry from the [Google Play](https://play.google.com/store/apps/details?id=com.openalbion.weaponry).'
    ],
    'help' => [
        'welcome' => 'Welcome from OpenAlbion Chatbot',
        'server' => '*/server east|west*: Set the server to East or West',
        'search' => '*/search name*: Check market price for a specific item',
        'language' => '*/language en|mm*: Set language to EN or MM',
        'timezone' => '*/timezone Continent/City*: Set your preferred timezone',
        'download' => '*/download*: Download the OpenAlbion Weaponry app',
        'about' => '*/about*: About OpenAlbion',
        'stop' => '*/stop*: Stop the current conversation',
        'current_server' => 'Your current server is :server.',
    ],
    'item' => [
        'cheapest' => '(The cheapest price for normal quality is :sellPrice silver at :city City)'
    ],
    'item_conversation' => [
        'question' => 'Please select an item from the options provided',
        'no_prices' => 'No prices found for :name on the :server server.',
        'no_items' => 'No items found for :name',
        'sorry' => 'Sorry, unable to perform the search at the moment.',
    ],
    'server_conversation' => [
        'message' => 'Your server has been set to *:server*.',
        'error' => 'The /server command only accepts *east* or *west* as valid options.'
    ],
    'language_conversation' => [
        'message' => 'Your language has been set to *:lang*.',
        'error' => 'The /language command only accepts *en* or *mm* as valid options.'
    ],
    'timezone_conversation' => [
        'message' => 'Your timezone has been set to *:tz*.',
        'error' => 'The /timezone command only accepts valid timezones. For example, you can use timezones like \'America/New_York\' or \'Asia/Yangon\'. Please refer to [this wikipedia link](https://en.wikipedia.org/wiki/List_of_tz_database_time_zones) for more details on available timezones.'
    ],
    'fallback_conversation' => 'Sorry, there is no response available for this message!',
    'sure' => 'Sure',
];
