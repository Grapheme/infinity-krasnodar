
@if(!is_null($channelCategory) && $cars->count())
<ul class="sub-offers-ul">

    <?
    #Helper::tad($cars);
    ?>

@foreach($cars as $car)
    <li data-model-id="{{ $car->product_id }}" data-model-year="{{ (int)$car->year }}" class="sub-offers-li">
        @if(!is_null($car->images) && File::exists(public_path('uploads/galleries/thumbs/'.$car->images->name)))
        <div class="sub-offers-li-head" style="background: url({{ asset('uploads/galleries/thumbs/'.$car->images->name) }}) no-repeat 0 0 / cover;">
            <a href="{{ link::to('car-for-sale/'.$car->link) }}"></a>
        </div>
        @endif
        <div class="sub-offers-li-body">
            <h3 class="sub-offers-li-header">
                 <a href="{{ link::to('car-for-sale/'.$car->link) }}">{{ $car->title }}</a>
            </h3>
            {{ $car->short }}
        </div>
@endforeach
</ul>
@endif