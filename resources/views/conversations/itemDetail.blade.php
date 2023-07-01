@foreach($items as $item)
@if($item['sell_price_min'] > 0)
## {{ $item['city'] }}

Sale Price - {{ $item['sell_price_min'] }} ({{\Carbon\Carbon::parse($item['sell_price_min_date'])->diffForHumans()}} | UTC)


@endif
@endforeach