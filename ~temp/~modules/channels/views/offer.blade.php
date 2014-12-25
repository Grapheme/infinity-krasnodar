@extends(Helper::layout())
@section('style')

@stop

@section('content')
<section class="top-bg">
    <header>
        <h2>{{ $element->channel->first()->title }}</h2>
        <div class="desc">
            {{ $element->channel->first()->short }}
        </div>
    </header>
    @if(File::exists(public_path('uploads/galleries/'.$element->channel->first()->images->name)))
        <div class="offer-img" style="background-image: url({{ asset('uploads/galleries/'.$element->channel->first()->images->name) }});"></div>
    @endif
</section>

<?php
    $channelCategory = ChannelCategory::where('slug',$element->slug)->first();
    $offers = Channel::where('category_id',@$channelCategory->id)->where('id','!=',$element->channel->first()->id)->orderBy('title')->with('images')->get();
?>
<section class="buy-offer information">
    <header>
        <div class="desc">
            {{ $element->channel->first()->desc }}
        </div>
    </header>
    @if($offers->count())
    <section class="buy-suboffer">
        <h2>Другие интересные предложения</h2>
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
</section>
@stop
@section('scripts')

@stop