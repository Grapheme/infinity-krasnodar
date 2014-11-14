<?php
    $header_models = ProductCategory::orderby('id')->with(array('product'=>function($query_product){
        $query_product->where('publication',1);
        $query_product->with(array('meta'=>function($query_product_meta){
            $query_product_meta->orderBy('title');
        }));
        $query_product->with('images');
        $query_product->with('menu_image');
        $query_product->with(array('related_products'=>function($query_related_product){
            $query_related_product->with(array('meta'=>function($query_related_product_meta){
                $query_related_product_meta->orderBy('title');
            }));
            $query_related_product->with('menu_image');
            $query_related_product->with('instocks');
        }));
        $query_product->with('instocks');
    }))->get();

    $pages_seo_url = array();
    $all_pages = I18nPage::with('metas')->get();
    foreach($all_pages as $page):
        $pages_seo_url[$page->slug] = $page->metas->first();
    endforeach;

    #$page_slug = Route::currentRouteName() == 'page' ? Config::get('page.slug') : false;
    $route = Route::currentRouteName();
    $page_slug = Config::get('page.slug');
?>

<header class="main-header{{ Request::is('/') ? '' : ' static-header' }}">
    @if(!Request::is('/'))
    <a href="{{ link::to() }}" class="logo"></a>
    @else
    <div class="logo"></div>
    @endif
    <div class="header-cont">
        <nav class="main-nav">
            <ul class="list-unstyled">
                <li class="option" data-option="about"><a href="{{ link::to(@$pages_seo_url['about']->seo_url) }}" class="@if($page_slug == @$pages_seo_url['about']->seo_url) active @endif">{{ @$pages_seo_url['about']->name }}</a>
                <li class="option" data-option="fix"><a href="{{ link::to(@$pages_seo_url['reserve-parts']->seo_url) }}" class="@if($page_slug == @$pages_seo_url['reserve-parts']->seo_url) active @endif">{{ @$pages_seo_url['reserve-parts']->name }}</a>
                <li class="option" data-option=""><a href="{{ link::to(@$pages_seo_url['offers']->seo_url) }}" class="@if($page_slug == @$pages_seo_url['offers']->seo_url) active @endif">{{ @$pages_seo_url['offers']->name }}</a>
                <li class="option" data-option="service"><a href="{{ link::to(@$pages_seo_url['services']->seo_url) }}" class="@if($page_slug == @$pages_seo_url['services']->seo_url) active @endif">{{ @$pages_seo_url['services']->name }}</a>
            </ul>
        </nav>
        <div class="head-models">
            <div class="header-main-menu">
            @foreach($header_models as $product_category)
                @if($product_category->product->count())
                <div class="model">
                    <div class="title">{{ $product_category->title }}</div>
                    <div class="items">
                    @foreach($product_category->product as $product)
                        @if($product->in_menu == 1)
                        <a class="js-tooltip @if($page_slug == $product->meta->first()->seo_url) active @endif" data-tooltip="model-{{ $product->id }}" href="{{ link::to(ProductionController::$prefix_url.'/'.$product->meta->first()->seo_url) }}">{{ $product->meta->first()->short_title  }}</a>
                        @endif
                    @endforeach
                    </div>
                </div>
                @endif
            @endforeach
                <div class="model">
                    <div class="title">&nbsp;</div>
                    <div class="items">
                        <a class="js-tooltip" data-tooltip="all" href="javascript:void(0);">Все модели</a>
                    </div>
                </div>
            </div>
            <div class="header-menu" data-option="about">
                <ul>
                    <li class="option"><a href="{{ link::to(@$pages_seo_url['about']->seo_url) }}">{{ @$pages_seo_url['about']->name }}</a>
                    <li class="option"><a href="{{ link::to(@$pages_seo_url['news']->seo_url) }}">{{ @$pages_seo_url['news']->name }}</a>
                    <li class="option"><a href="{{ link::to(@$pages_seo_url['history']->seo_url) }}">{{ @$pages_seo_url['history']->name }}</a>
                    <li class="option"><a href="{{ link::to(@$pages_seo_url['contacts']->seo_url) }}">{{ @$pages_seo_url['contacts']->name }}</a>
                </ul>
            </div>
            <div class="header-menu" data-option="service">
                <ul>
                    <li class="option"><a href="{{ link::to(@$pages_seo_url['services']->seo_url.'#finance') }}">Автокредитование</a>
                    <li class="option"><a href="{{ link::to(@$pages_seo_url['services']->seo_url.'#insurance') }}">Страхование</a>
                    <li class="option"><a href="{{ link::to(@$pages_seo_url['services']->seo_url.'#tradein') }}">Trade-in</a>
                </ul>
            </div>
            <div class="header-menu" data-option="fix">
                <ul>
                    <li class="option"><a href="{{ link::to(@$pages_seo_url['reserve-parts']->seo_url.'#service') }}">Сервис</a>
                    <li class="option"><a href="{{ link::to(@$pages_seo_url['reserve-parts']->seo_url.'#spares') }}">Запчасти</a>
                    <li class="option"><a href="{{ link::to(@$pages_seo_url['reserve-parts']->seo_url.'#guarantee') }}">Гарантия</a>
                    <li class="option"><a href="{{ link::to(@$pages_seo_url['reserve-parts']->seo_url.'#vip') }}">VIP обслуживание</a>
                    <li class="option"><a href="{{ link::to(@$pages_seo_url['reserve-parts-accessories']->seo_url) }}">Аксессуары</a>
                </ul>
            </div>
        </div>
    </div>
    <div class="header-right">
        <div class="search">
            {{ Form::open(array('url'=>link::to('search/request'),'method'=>'post')) }}
            <input type="text" placeholder="Поиск" name="search_request" class="search-input" value="{{ Input::get('query') }}">
            <button type="submit" class="search-btn"><i class="fa fa-search"></i></button>
            {{ Form::close() }}
        </div>
        <a href="javascript:void(0);" class="gedon-link"></a>
    </div>
</header>

<section class="overlay">
    <div class="pop-window pop-dtest closed" data-popup="test-drive">
        <i class="js-pop-close">&#x2715;</i>
        <div class="dtest-in">
            <div class="title">Запись<br>на тест-драйв</div>
            <div class="dtest-form">
                {{ Form::open(array('url'=>URL::route('order_textdrive_call'),'role'=>'form','class'=>'smart-form order-testdrive-form','id'=>'order-testdrive-form0','method'=>'post')) }}
                    <section>
                        <input type="text" name="fio" class="dtest-input" placeholder="Ф.И.О.">
                    </section>
                    <section>
                        <input type="text" name="phone" class="dtest-input" placeholder="Телефон">
                    </section>
                    <section>
                        <input type="text" name="email" class="dtest-input" placeholder="Email">
                    </section>
                    <section>
                        <input type="hidden" name="product_id" class="hidden-model" value="{{ is_object($product) ? $product->id : '' }}">
                    </section>
                    <button type="submit" class="btn fl-r">Отправить</button>
                {{ Form::close() }}
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="pop-window pop-dtest closed" data-popup="test-drive-models">
        <i class="js-pop-close">&#x2715;</i>
        <div class="dtest-in">
            <div class="title">Запись<br>на тест-драйв</div>
            <div class="dtest-form">
                {{ Form::open(array('url'=>URL::route('order_textdrive_call'),'role'=>'form','class'=>'smart-form','id'=>'order-testdrive-form','method'=>'post')) }}
                    <fieldset>
                        <section>
                            <input type="text" name="fio" class="dtest-input" placeholder="Ф.И.О.">
                        </section>
                        <section>
                            <input type="text" name="phone" class="dtest-input" placeholder="Телефон">
                        </section>
                        <section>
                            <input type="text" name="email" class="dtest-input" placeholder="Email">
                        </section>
                        <section>
                            <select name="product_id" autoconplete="off" class="testSelect">
                                    <option value="">Выберите модель</option>
                            @foreach($header_models as $product_category)
                                @if($product_category->product->count())
                                    @foreach($product_category->product as $product)
                                        @if($product->in_menu == 1)
                                            <option value="{{ $product->id }}">{{ $product->meta->first()->title  }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                            </select>
                        </section>
                     </fieldset>
                    <footer>
                        <button type="submit" autocomplete="off" class="btn fl-r btn-form-submit">
                            <i class="fa fa-spinner fa-spin hidden"></i> <span class="btn-response-text">Отправить</span>
                        </button>
                    </footer>
                 {{ Form::close() }}
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="pop-window pop-dtest closed" data-popup="recover">
        <i class="js-pop-close">&#x2715;</i>
        <div class="dtest-in">
            <div class="title">Запись<br>на сервис</div>
            <div class="dtest-form">
                {{ Form::open(array('url'=>URL::route('order_service'),'role'=>'form','class'=>'smart-form','id'=>'order-service-form','method'=>'post')) }}
                    <fieldset>
                        <section>
                            <input type="text" name="fio" class="dtest-input" placeholder="Ф.И.О.">
                        </section>
                        <section>
                            <input type="text" name="phone" class="dtest-input" placeholder="Телефон">
                        </section>
                        <section>
                            <input type="text" name="email" class="dtest-input" placeholder="Email">
                        </section>
                         <section>
                            <input type="text" name="content" class="dtest-input" placeholder="Комментарий">
                        </section>
                        <section>
                           <input type="text" name="product" class="dtest-input" placeholder="Модель">
                        </section>
                    </fieldset>
                    <footer>
                        <button type="submit" autocomplete="off" class="btn fl-r btn-form-submit">
                            <i class="fa fa-spinner fa-spin hidden"></i> <span class="btn-response-text">Отправить</span>
                        </button>
                    </footer>
                 {{ Form::close() }}
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="pop-window pop-dtest closed" data-popup="items">
        <i class="js-pop-close">&#x2715;</i>
        <div class="dtest-in">
            <div class="title">Заказ<br>запчастей</div>
            <div class="dtest-form">
                {{ Form::open(array('url'=>URL::route('order_reserve'),'role'=>'form','class'=>'smart-form','id'=>'order-reserve-form','method'=>'post')) }}
                    <fieldset>
                        <section>
                        <input type="text" name="fio" class="dtest-input" placeholder="Ф.И.О.">
                    </section>
                    <section>
                        <input type="text" name="phone" class="dtest-input" placeholder="Телефон">
                        </section>
                        <section>
                            <input type="text" name="email" class="dtest-input" placeholder="Email">
                        </section>
                        <section>
                            <input type="text" name="content" class="dtest-input" placeholder="Комментарий">
                        </section>
                    </fieldset>
                    <footer>
                        <button type="submit" autocomplete="off" class="btn fl-r btn-form-submit">
                            <i class="fa fa-spinner fa-spin hidden"></i> <span class="btn-response-text">Отправить</span>
                        </button>
                    </footer>
                 {{ Form::close() }}
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="pop-window pop-dtest closed" data-popup="call">
        <i class="js-pop-close">&#x2715;</i>
        <div class="dtest-in">
            <div class="title">Заказ<br>звонка</div>
            <div class="dtest-form">
                {{ Form::open(array('url'=>URL::route('index_order_call'),'role'=>'form','class'=>'smart-form','id'=>'index-order-call-form','method'=>'post')) }}
                    <section>
                        <input type="text" class="dtest-input" name="fio" placeholder="Ф.И.О.">
                    </section>
                    <section>
                        <input type="text" class="dtest-input" name="phone" placeholder="Телефон">
                    </section>
                    <section>
                        <input type="text" class="dtest-input" name="datetime" placeholder="Удобное время для звонка">
                    </section>
                    <button type="submit" autocomplete="off" class="btn fl-r btn-form-submit">
                        <i class="fa fa-spinner fa-spin hidden"></i> <span class="btn-response-text">Отправить</span>
                    </button>
                {{ Form::close() }}
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</section>

@if($header_models->count())
<!--
<?
#Helper::ta($header_models);
?>
-->
<div class="tooltip-cont">
@foreach($header_models as $product_category)
    @foreach($product_category->product as $product)
    <div class="car-tooltip js-tooltip-block" data-tooltip="model-{{ $product->id }}">
        <i class="tool-triangle"></i>
        @if($product->related_products->count())
        <div class="left-block">
            <ul class="car-ul js-smartabs">
                 <li>
                    @if(!is_null($product->menu_image) && File::exists(public_path('uploads/galleries/'.$product->menu_image->name)))
                        <div class="car-photo" style="background-image: url({{ asset('uploads/galleries/'.$product->menu_image->name) }})"></div>
                    @endif
                    <div class="car-name">{{ trim(preg_replace('~infiniti~is', '', $product->meta->first()->title)) }}</div>

                    @foreach($product->related_products as $related_product)
                        <li>
                        @if(!is_null($related_product->menu_image) && File::exists(public_path('uploads/galleries/'.$related_product->menu_image->name)))
                            <div class="car-photo" style="background-image: url({{ asset('uploads/galleries/'.$related_product->menu_image->name) }})"></div>
                        @endif
                            <div class="car-name">{{ trim(preg_replace('~infiniti~is', '', $related_product->meta->first()->title)) }}</div>
                    @endforeach

            </ul>
        </div><!--
        --> @endif
        <div class="main-blocks">
            @if(!is_null($product->menu_image) && File::exists(public_path('uploads/galleries/'.$product->menu_image->name)))
            <div class="main-block" style="background-image: url({{ asset('uploads/galleries/'.$product->menu_image->name) }})">
            @else
            <div class="main-block">
            @endif
                <div class="car-name">
                    {{ trim(preg_replace('~infiniti~is', '', $product->meta->first()->title)) }}
                    @if ($product->instocks->count())
                        <a class="cars-instock" href="{{ link::to(@$pages_seo_url['cars-in-stock']->seo_url.'?model='.$product->id) }}">
                            {{--{{ $product->instocks->count() }} {{ $product->meta->first()->title }} в наличии--}}
                            {{ trans_choice(':count автомобиль|:count автомобиля|:count автомобилей', $product->instocks->count(), array(), 'ru') }} в наличии
                        </a>
                    @endif
                </div>
                <div class="car-desc">{{ $product->meta->first()->in_menu_content }}</div>
                <div class="car-btns">
                    <a href="{{ link::to(ProductionController::$prefix_url.'/'.$product->meta->first()->seo_url) }}" class="drive-btn"><span class="icon icon-page"></span>Подробнее</a>
                    <!--<a href="javascript:void(0);" class="drive-btn js-pop-show" data-popup="test-drive" data-model="{{ $product->meta->first()->title }}"><span class="icon icon-wheel"></span>Записаться на тестдрайв</a>
                    @if(!empty($product->brochure) && File::exists(public_path($product->brochure)))
                    <a class="drive-btn" target="_blank" href="{{ asset($product->brochure) }}"><span class="icon icon-bricks"></span>Брошюра</a>
                    @endif-->
                </div>
            </div>
        @foreach($product->related_products as $related_product)
            @if(!is_null($related_product->menu_image) && File::exists(public_path('uploads/galleries/'.$related_product->menu_image->name)))
            <div class="main-block" style="background-image: url({{ asset('uploads/galleries/'.$related_product->menu_image->name) }})">
            @else
            <div class="main-block">
            @endif
                <div class="car-name">
                    {{ trim(preg_replace('~infiniti~is', '', $related_product->meta->first()->title)) }}
                    @if ($related_product->instocks->count())
                        <a class="cars-instock" href="{{ link::to(@$pages_seo_url['cars-in-stock']->seo_url.'?model='.$related_product->id) }}">
                            {{--{{ $related_product->instocks->count() }} {{ $related_product->meta->first()->title }} в наличии--}}
                            {{ trans_choice(':count автомобиль|:count автомобиля|:count автомобилей', $related_product->instocks->count(), array(), 'ru') }} в наличии
                        </a>
                    @endif
                </div>
                <div class="car-desc">{{ $related_product->meta->first()->in_menu_content }}</div>
                <div class="car-btns">
                    <a href="{{ link::to(ProductionController::$prefix_url.'/'.$related_product->meta->first()->seo_url) }}" class="drive-btn"><span class="icon icon-page"></span>Подробнее</a>
                    <!--<a href="javascript:void(0);" class="drive-btn js-pop-show" data-popup="test-drive" data-model="{{ $product->meta->first()->title }}"><span class="icon icon-wheel"></span>Записаться на тестдрайв</a>
                    @if(!empty($related_product->brochure) && File::exists(public_path($related_product->brochure)))
                    <a class="drive-btn" target="_blank" href="{{ asset($related_product->brochure) }}"><span class="icon icon-bricks"></span>Брошюра</a>
                    @endif-->
                </div>
            </div>
        @endforeach
        </div>
    </div>
    @endforeach
@endforeach
    <div class="cars-tooltip js-tooltip-block" data-tooltip="all">
        <div class="tool-triangle"></div>
        @foreach($header_models as $product_category)
            @if($product_category->product->count())
            <div class="car-block">
                <div class="car-type">{{ $product_category->title }}</div>
                <ul class="cars-ul">
                 @foreach($product_category->product as $product)
                    <li>
                        <a href="{{ link::to(ProductionController::$prefix_url.'/'.$product->meta->first()->seo_url) }}" class="full-a"></a>
                    @if(!is_null($product->menu_image) && File::exists(public_path('uploads/galleries/thumbs/'.$product->menu_image->name)))
                        <div class="car-photo" style="background-image: url({{ asset('uploads/galleries/thumbs/'.$product->menu_image->name) }});"></div>
                    @endif
                        <div class="car-name">{{ trim(preg_replace('~infiniti~is', '', $product->meta->first()->title)) }}</div>
                 @endforeach
                </ul>
            </div>
            @endif
        @endforeach
    </div>
</div>
@endif