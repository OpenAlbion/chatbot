<?php

return [
    'about' => 'OpenAlbion ဆိုတာကတော့ developer တွေအတွက် Albion Online ရဲ့ data တွေကို api ထုတ်ပေးတဲ့ open-source project တစ်ခုပါ။ အဓိကရည်ရွယ်ချက်ကတော့ OpenAlbion ရဲ့ api တွေကို သုံးပြီး application တွေ၊ website တွေ၊ chatbot တွေ ကိုယ်တိုင်ဖန်းတီးနိုင်ဖို့ပါ။',
    'download' => [
        'intro' => 'OpenAlbion Weaponry ဆိုတာကတော့ Albion Online ရဲ့ weapon တွေ၊ armor တွေ၊ mount တွေအပြင် အခြား item တွေပါ တစ်နေရာထဲကနေ သက်ဆိုင်ရာ အမျိုးစားအလိုက် ကြည့်လို့ရတဲ့ application တစ်ခုပါ။ Item တစ်ခုချင်းဆီရဲ့ market price တွေ၊ spell တွေ၊ enchantment အလိုက် stats တွေ လည်းပါဝင်ပါတယ်။',
        'link' => 'Application ကို [Play Store](https://play.google.com/store/apps/details?id=com.openalbion.weaponry) ကနေတစ်ဆင့် download ဆွဲလို့ရပါတယ်။'
    ],
    'help' => [
        'welcome' => 'OpenAlbion Chatbot မှ ကြိုဆိုပါတယ်',
        'server' => '*/server east|west*: East (သို့မဟုတ်) West ဆာဗာ သတ်မှတ်ရန်',
        'search' => '*/search name*: Market price ရှာဖွေရန်',
        'language' => '*/language en|mm*: ဘာသာစကား သတ်မှတ်ရန်',
        'timezone' => '*/timezone Continent/City*: Timezone သတ်မှတ်ရန်',
        'download' => '*/download*: OpenAlbion Weaponry အား download ဆွဲရန်',
        'about' => '*/about*: OpenAlbion အကြောင်း',
        'stop' => '*/stop*: စကားဆက်မပြောရန်',
        'current_server' => 'သင်အခု :server ဆာဗာမှာ ဖြစ်ပါတယ်။',
    ],
    'item' => [
        'cheapest' => '(:city မြို့မှာ :sellPrice silver နဲ့ စျေးအသက်သာဆုံး ဝယ်ယူနိုင်ပါတယ်)'
    ],
    'item_conversation' => [
        'question' => 'Item တစ်ခုရွေးချယ်ပါ',
        'no_prices' => ':server မှာ :name အတွက် စျေးနှုန်း ရှာမတွေ့ပါ။',
        'no_items' => ':name အတွက် ပစ္စည်း ရှာမတွေ့ပါ',
        'sorry' => 'အားနာပါတယ်။ ယခု လုပ်ဆောင်ချက်ကို မလုပ်ဆောင်နိုင်သေးပါ။',
    ],
    'server_conversation' => [
        'message' => '*:server* server အဖြစ် သတ်မှတ်ပြီးပါပြီ။',
        'error' => '/server အတွက် east (သို့မဟုတ်) west တစ်ခုပဲ လက်ခံပါတယ်။'
    ],
    'language_conversation' => [
        'message' => '*:lang* ဘာသာစကား အဖြစ် သတ်မှတ်ပြီးပါပြီ။',
        'error' => '/language အတွက် en (သို့မဟုတ်) mm တစ်ခုပဲ လက်ခံပါတယ်။'
    ],
    'timezone_conversation' => [
        'message' => '*:tz* timezone အဖြစ် သတ်မှတ်ပြီးပါပြီ။',
        'error' => '/timezone အတွက် မှန်ကန်စွာ ရိုက်ထည့်ပေးဖို့လိုပါတယ်(ဥပမာ - Asia/Yangon)။ အသေးစိတ်ကို [ဒီလင့်](https://en.wikipedia.org/wiki/List_of_tz_database_time_zones) မှာကြည့်လို့ရပါတယ်။'
    ],
    'fallback_conversation' => 'အားနာပါတယ်။ ယခု message အတွက် ပြန်လည်လုပ်ဆောင်နိုင်ခြင်း မရှိသေးပါ။',
    'sure' => 'ဟုတ်ကဲ့',
];
