@foreach($itemGroups as $city => $items)
@if(collect($items)->sum('sell_price_min') > 0)
*{{ $items[0]['city'] }}*
@endif
@foreach($items as $item)
@if($item['sell_price_min'] > 0)
@php
	$quality = 'Normal';
	if($item['quality'] == 1) {
		$quality = 'Normal';
	} elseif($item['quality'] == 2) {
		$quality = 'Good';
	} elseif($item['quality'] == 3) {
		$quality = 'Outstanding';
	} elseif($item['quality'] == 4) {
		$quality = 'Excellent';
	} elseif($item['quality'] == 5) {
		$quality = 'Masterpiece';
	}
@endphp
{{ $quality }} - {{ number_format($item['sell_price_min']) }} ({{\Carbon\Carbon::parse($item['sell_price_min_date'])->diffForHumans()}} | UTC)
@endif
@endforeach

@endforeach

@php
$cheapestItem = collect($flatItems)->where('quality', 1)
	->sortBy('sell_price_min')
	->where('sell_price_min', '>', 0)
	->first();
@endphp

@if($cheapestItem && $cheapestItem['sell_price_min'] > 0)
{{ __('messages.item.cheapest', [
		'sellPrice' => number_format($cheapestItem['sell_price_min']),
		'city' => $cheapestItem['city'],
	]) }}
@endif