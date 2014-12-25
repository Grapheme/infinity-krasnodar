<?php
    $channelCategory = ChannelCategory::where('slug','offer')->first();
    $offers = Channel::where('category_id',@$channelCategory->id)->orderBy('title')->with('images')->get();
?>
@if(!is_null($channelCategory) && $offers->count())
<section class="buy-offer inf-block">
        <h1>{{ $channelCategory->title }}</h1>
        <ul class="sub-offers-ul">
        @foreach($offers as $offer)
            <li class="sub-offers-li">
                @if(File::exists(public_path('uploads/galleries/'.$offer->images->name)))
               <div class="sub-offers-li-head" style="background: url({{ asset('uploads/galleries/thumbs/'.$offer->images->name) }}) no-repeat 0 0 / cover;">
                   @if(!empty($offer->link))
                   <a href="{{ link::to('offer/'.$offer->link) }}"></a>
                   @endif
               </div>
               @endif
                <div class="sub-offers-li-body">
                    <h3 class="sub-offers-li-header">
                    @if(!empty($offer->link))
                    <a href="{{ link::to('offer/'.$offer->link) }}">{{ $offer->title }}</a>
                    @else
                        {{ $offer->title }}
                    @endif
                    </h3>
                    <div class="sub-offers-li-desc">
                        {{ $offer->short }}
                    </div>
                </div>
        @endforeach
        </ul>
</section>
@endif