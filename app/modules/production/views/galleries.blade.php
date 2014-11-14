@extends(Helper::layout())

@section('style')
    {{ HTML::style('theme/css/fotorama.css') }}
@stop

@section('content')
@include('production/views/accepts/product-menu')
@if($product->product_galleries->count())
<div class="gallery">
    @foreach($product->product_galleries as $slider)
        @if($slider->gallery->photos->count())
        <section class="gallery-block gallery-top">
            @if($slider->gallery->photos->count() > 1)
            <a href="#" class="gal-prev"></a>
            <a href="#" class="gal-next"></a>
            <a href="#" class="gal-down"><i class="fa fa-angle-double-down"></i></a>
            @endif
            <div class="wrapper">
                <div class="gallery-info">
                    @if (0)
                    <div class="title">{{ $product->meta->first()->title }}</div>
                    <div class="inf-text">{{ $product->meta->first()->preview }}</div>
                    @endif
                    <div class="title">{{ $slider->title }}</div>
                    <div class="inf-text">{{ $slider->desc }}</div>
                </div>
            </div>
            <div class="gallery-photo">
                @foreach($slider->gallery->photos as $photo)
                <img src="{{ asset('uploads/galleries/'.$photo->name) }}" alt="">
                @endforeach
            </div>
        </section>
        @endif
    @endforeach
</div>
@endif
@if($product->videos->count())
<section class="gallery-block gallery-top">
    @foreach($product->videos as $video)
    <!--<div class="gal-half" style="background-image: url(/theme/img/gallery/video1.jpg)"><a href="#" class="gal-play"></a></div>-->
    <div class="gal-half">
        {{ $video->content  }}
    </div>
    @endforeach
</section>
@endif
@stop
@section('scripts')
    {{ HTML::script('theme/js/vendor/fotorama.js') }}
@stop
@section('page_script')
    <script>
        $('.gallery').galleryAnim();
        $('.gallery-photo').each(function(){
            var $fotoramaDiv = $(this).fotorama({
                'fit': 'cover',
                'nav': false,
                'width': '100%',
                'height': '100%',
                'loop': true,
                'arrows': false
            });
            var fotorama = $fotoramaDiv.data('fotorama');

            $(this).parent().find('.gal-prev').on('click', function(){
                fotorama.show('<');
                return false;
            });
            $(this).parent().find('.gal-next').on('click', function(){
                fotorama.show('>');
                return false;
            });
        });
    </script>
@stop