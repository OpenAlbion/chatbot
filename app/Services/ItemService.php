<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ItemService
{
    public function search(string $search): array
    {
        $items = Cache::remember('aod.items', 3600, function () {
            return collect(Storage::json('items.json'));
        });

        return $items->filter(function ($item) use ($search) {
            return Str::contains($item['name'], $search, true);
        })->values()->take(10)->toArray();
    }

    public function detail(string $region, string $itemId): ?string
    {
        $response = Http::aod($region, $itemId);
        if ($response->ok()) {
            return view('conversations.itemDetail', ['items' => $response->json()])
                ->render();
        }

        return null;
    }
}
