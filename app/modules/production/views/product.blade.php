@extends(Helper::layout())

@section('style')
    {{HTML::style('theme/css/fotorama.css');}}
@stop

@section('content')
@include('production/views/accepts/product-menu')
 <section class="auto-slider">
    <div class="model-fotorama">
        @if (is_object($product->gallery))
            @foreach($product->gallery->photos as $image)
                <img src="{{ asset('uploads/galleries/'.$image->name) }}">
            @endforeach
        @endif
    </div>
    <div class="color-container">
        <div class="color-fotorama">
            @foreach($product->colors as $product_color)
                @if (is_object($product_color->images))
                    @if(File::exists(public_path('uploads/galleries/'.$product_color->images->name)))
                        <img src="{{ $product_color->images->full() }}" alt="">
                    @endif
                @endif
            @endforeach
        </div>
    </div>

    <div class="slider-window">
        <div class="model-cont">
            @if($product->colors->count())
            <a class="drive-btn colorView" href="#"><span class="icon icon-circle"></span> Выбор цвета</a>
            @endif
            <div class="auto-info">
                <div class="car-name">{{ $product->meta->first()->title }}</div>
                <div class="car-desc">{{ $product->meta->first()->preview }}</div>
                <div class="price">{{ $product->meta->first()->price }}</div>
                <div class="text"></div>
                <a href="javascript:void(0);" class="drive-btn js-pop-show" data-popup="test-drive">
                    <span class="icon icon-wheel"></span> Записаться на тест-драйв
                </a>
            </div>
        </div>

        @if($product->colors->count())
        <div class="color-cont">
            <div class="color-head">Выбор цвета</div>
            <div class="color-close">✕</div>
            <div class="color-name"></div>
            <ul class="colors-list">
            @foreach($product->colors as $product_color)
                @if (is_object($product_color->images))
                    @if(File::exists(public_path('uploads/galleries/'.$product_color->images->name)))
                        <li class="color-item" style="background-color: {{ $product_color->color }};" data-color="{{ $product_color->color }}" title="{{ $product_color->title }}"></li>
                    @endif
                @endif
            @endforeach
            </ul>
        </div>
        @endif
    </div>

</section>
<section class="model-sect">
    {{ $product->meta->first()->content }}
</section>
@stop


@section('scripts')
    {{HTML::script('theme/js/vendor/fotorama.js');}}
@stop


@section('page_script')
    <script>
        $(window).on('load', function(){
            $('.model-fotorama').fotorama({
                'width': '1240px',
                'height': '550px',
                'fit': 'cover',
                'loop': true,
                'arrows': false,
                'nav': 'thumbs',
                'thumbheight': '112px',
                'thumbwidth': '215px',
                'click': false
            });
            var $fotoramaDiv = $('.color-fotorama').fotorama({
                'width': '1240px',
                'height': '550px',
                'fit': 'cover',
                'arrows': false,
                'nav': false,
                'thumbheight': '112px',
                'thumbwidth': '215px',
                'click': false,
                'swipe': false,
                'trackpad': false,
                'transition': 'crossfade'
            });
            var color_fotorama = $fotoramaDiv.data('fotorama');
            //$fotoramaDiv.hide();
            function setCName(id) {
                $('.color-name').text($('.color-item').eq(id).attr('title'));
            }
            function setColor(id) {
                setCName(id);
                color_fotorama.show(id);
            }
            if($('.color-item').length != 0) {
                $('.color-item').eq(0).addClass('active');
            }
            setCName(0);
            $(document).on('click', '.color-item', function(){
                var id = $(this).index();
                $(this).addClass('active').siblings().removeClass('active');
                setColor(id);
            });
        });

    </script>
@stop