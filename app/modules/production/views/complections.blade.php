@extends(Helper::layout())

@section('style')
@stop

@section('content')
@include('production/views/accepts/product-menu')
@if($product->complections->count())
<section class="complectations inf-block">
    <header class="clearfix">
        <h1>Комплектации и цены</h1>
        <div class="filter">
            <ul class="filter-ul">
                <li class="filter-li"><a href="#" class="js-comlink" data-type="desc">Описание</a>
                <li class="filter-li"><a href="#" class="js-comlink" data-type="dynam">Динамика</a>
                <li class="filter-li"><a href="#" class="js-comlink" data-type="exter">Экстерьер</a>
                <li class="filter-li"><a href="#" class="js-comlink" data-type="inter">Интерьер</a>
            </ul>
        </div>
    </header>
    <ul class="car-list">
    @foreach($product->complections as $complection)
        <li class="car-item">
            <div class="car-head">
                <h3>{{ $complection->title }}</h3>
                <div class="car-price">{{ $complection->price }}</div>
        @if(!empty($complection->images))
            @if(File::exists(public_path('uploads/galleries/thumbs/'.$complection->images->name)))
                <img class="car-image" src="{{ asset('uploads/galleries/thumbs/'.$complection->images->name) }}" alt="">
            @endif
        @endif
            </div><!--
         --><div class="car-body">
                @if(FALSE)
                    <div class="car-links">
                    @if(!empty($complection->brochure) && File::exists(public_path($complection->brochure)))
                         <a target="_blank" class="" href="{{ asset($complection->brochure) }}"><span class="icon icon-bricks"></span> Брошюра</a>
                    @endif
                    {{--
                        <a class="" href="javascript:void(0);"><span class="icon icon-wheel"></span> Записаться на тест-драйв</a>
                        <a class="" href="javascript:void(0);"><span class="icon icon-page"></span> Подробнее</a>
                    --}}
                    </div>
                @endif
                <div class="js-comtab" data-type="desc">
                    {{ $complection->description }}
                </div>
                <div class="js-comtab" data-type="dynam">
                    {{ $complection->dynamics }}
                </div>
                <div class="js-comtab" data-type="exter">
                    {{ $complection->exterior }}
                </div>
                <div class="js-comtab" data-type="inter">
                    {{ $complection->interior }}
                </div>
            </div>
        </li>
    @endforeach
    </ul>
    <div class="dict">
        *для автомобилей, окрашенных краской белый перламутр (QAA), 
        увеличение рекомендованной розничной цены на автомобиль, 
        включая НДС, составляет 50 000 рублей.
    </div>
</section>
@endif
@stop
@section('page_script')
    <script>
        var comtabs = (function(){
            function init() {
                $('.js-comtab').first().siblings().hide();
                $('.js-comlink').first().trigger('click');
            }
            $('.js-comlink').on('click', function(){
                $(this).addClass('active').parent().siblings().find('a').removeClass('active');
                $('.js-comtab[data-type="' + $(this).attr('data-type') + '"]').show().siblings().hide();
                return false;
            });
            $(function(){
                init();
            });
        })();
    </script>
@stop