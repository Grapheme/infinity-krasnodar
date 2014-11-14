@extends(Helper::layout())
@section('style')

@stop

@section('content')
<section class="used-car sect-wrapper">
    <header>
        <h1>{{ $element->channel->first()->title }}</h1>
        <div class="year">{{ $element->channel->first()->year }}</div>
        <div class="price">{{ $element->channel->first()->price }}</div>
    </header>
</section>

@if(!is_null($element->channel[0]->gallery) && $element->channel[0]->gallery->photos->count())
<section class="jcarousel-wrapper">
    <div class="jcarousel">
        <ul><!--
        @foreach($element->channel->first()->gallery->photos as $photo)
            --><li><img src="{{ $photo->full() }}"></li><!--
        @endforeach
        --></ul>
    </div>
    <a href="#" class="jcarousel-control jcarousel-control-prev"><span class="icon icon-angle-left"></span></a>
    <a href="#" class="jcarousel-control jcarousel-control-next"><span class="icon icon-angle-right"></span></a>
</section>
@endif
<section class="used-car sect-wrapper">
    <div class="used-car-options clearfix">
        <div class="chars">
            <h2>Характеристики</h2>
            {{ $element->channel->first()->short }}
        </div>
        <div class="complectation">
            <h2>
                Комплектация
            </h2>
            <div class="desc">
               {{ $element->channel->first()->desc }}
            </div>
        </div>
    </div>
</section>
@stop
@section('page_script')
    {{ HTML::script("theme/js/vendor/jcarousel.min.js") }}
    <script>
        $(function() {
            $('.jcarousel').jcarousel();

            $('.jcarousel-control-prev')
                .on('jcarouselcontrol:active', function() {
                    $(this).removeClass('inactive');
                })
                .on('jcarouselcontrol:inactive', function() {
                    $(this).addClass('inactive');
                })
                .jcarouselControl({
                    target: '-=1'
                });

            $('.jcarousel-control-next')
                .on('jcarouselcontrol:active', function() {
                    $(this).removeClass('inactive');
                })
                .on('jcarouselcontrol:inactive', function() {
                    $(this).addClass('inactive');
                })
                .jcarouselControl({
                    target: '+=1'
                });

            $('.jcarousel-pagination')
                .on('jcarouselpagination:active', 'a', function() {
                    $(this).addClass('active');
                })
                .on('jcarouselpagination:inactive', 'a', function() {
                    $(this).removeClass('active');
                })
                .jcarouselPagination();
        });
    </script>
@stop