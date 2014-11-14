<?php
    $footer_models = ProductCategory::orderby('id')->with(array('product'=>function($query_product){
        $query_product->where('publication',1);
        $query_product->where('in_menu',1);
        $query_product->with(array('meta'=>function($query_product_meta){
            $query_product_meta->orderBy('title');
        }));
    }))->get();

    $pages_seo_url = array();
    $all_pages = I18nPage::with('metas')->get();
    foreach($all_pages as $page):
        $pages_seo_url[$page->slug] = $page->metas->first();
    endforeach;
?>
<footer class="main-footer">
    <div class="footer-top">
        <div class="footer-left">
            <div class="footer-block">
                <div class="title">Модели</div>
                <ul class="footer-ul">
            @foreach($footer_models as $product_category)
                @foreach($product_category->product as $product)
                    <li class="option"><a href="{{ link::to(ProductionController::$prefix_url.'/'.$product->meta->first()->seo_url) }}">{{ $product->meta->first()->short_title  }}</a>
                @endforeach
            @endforeach
                </ul>
            </div>
            <div class="footer-block">
                <div class="title">О компании</div>
                <ul class="footer-ul">
                    {{--
                    <li class="option"><a href="{{ link::to('persons-of-the-company') }}">Лица компании</a>
                    <li class="option"><a href="{{ link::to('vacancies') }}">Вакансии</a>
                    <li class="option"><a href="{{ link::to('club') }}">Клуб</a>
                    --}}

                    <li class="option"><a href="{{ link::to(@$pages_seo_url['about']->seo_url) }}">{{ @$pages_seo_url['about']->name }}</a>
                    <li class="option"><a href="{{ link::to(@$pages_seo_url['news']->seo_url) }}">{{ @$pages_seo_url['news']->name }}</a>
                    <li class="option"><a href="{{ link::to(@$pages_seo_url['history']->seo_url) }}">{{ @$pages_seo_url['history']->name }}</a>
                    <li class="option"><a href="{{ link::to(@$pages_seo_url['contacts']->seo_url) }}">{{ @$pages_seo_url['contacts']->name }}</a>
                </ul>
            </div>
            <div class="footer-block">
                <div class="title">Услуги</div>
                <ul class="footer-ul">
                    {{--
                    <li class="option"><a href="{{ link::to('services-warranty') }}">Гарантия</a>
                    <li class="option"><a href="{{ link::to('services-maintenance-program') }}">Программы ТО</a>
                    --}}

                    <li class="option"><a href="{{ link::to(@$pages_seo_url['services']->seo_url.'#finance') }}">Автокредитование</a>
                    <li class="option"><a href="{{ link::to(@$pages_seo_url['services']->seo_url.'#insurance') }}">Страхование</a>
                    <li class="option"><a href="{{ link::to(@$pages_seo_url['services']->seo_url.'#tradein') }}">Trade-in</a>

                </ul>
            </div>
            <div class="footer-block">
                <div class="title">Сервис и запчасти</div>
                <ul class="footer-ul">
                    {{--
                    <li class="option"><a href="{{ link::to('reserve-parts-warranty') }}">Гарантия</a>
                    <li class="option"><a href="{{ link::to('reserve-parts-maintenance-program') }}">Программы ТО</a>
                    <li class="option"><a href="{{ link::to('reserve-parts') }}">Запчасти</a>
                    <li class="option"><a href="{{ link::to('reserve-parts-accessories') }}">Аксессуары</a>
                    --}}

                    <li class="option"><a href="{{ link::to(@$pages_seo_url['reserve-parts']->seo_url.'#service') }}">Сервис</a>
                    <li class="option"><a href="{{ link::to(@$pages_seo_url['reserve-parts']->seo_url.'#spares') }}">Запчасти</a>
                    <li class="option"><a href="{{ link::to(@$pages_seo_url['reserve-parts']->seo_url.'#guarantee') }}">Гарантия</a>
                    <li class="option"><a href="{{ link::to(@$pages_seo_url['reserve-parts']->seo_url.'#vip') }}">VIP обслуживание</a>
                    <li class="option"><a href="{{ link::to(@$pages_seo_url['reserve-parts-accessories']->seo_url) }}">Аксессуары</a>

                </ul>
            </div>
            <div class="footer-block">
                <div class="title">Автомобили</div>
                <ul class="footer-ul">
                    <li class="option"><a href="{{ link::to(@$pages_seo_url['cars-in-stock']->seo_url) }}">В наличии</a>
                    <li class="option"><a href="{{ link::to(@$pages_seo_url['cars-for-sale']->seo_url) }}">С пробегом</a>
                </ul>
            </div>
        </div>
        <div class="footer-right">
            <adress class="contact-block">
                346715, г. Ростовская обл.,<br>
                Аксайский р-н, п. Янтарный,<br>
                Новочеркасское шоссе, 16В
            </adress>
            <div class="contact-block">
                <a href="tel:+78632928892" class="contact-link">+7 863-292-88-92</a><br>
                <a href="tel:+78633050500" class="contact-link">+7 863 305-05-00</a>
            </div>
            <div class="soc-icons">
                <a href="{{ link::to() }}" class="soc-link icon-fb"></a>
                <a href="{{ link::to() }}" class="soc-link icon-vk"></a>
                <a href="{{ link::to() }}" class="soc-link icon-in"></a>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="footer-bottom">
        <span>© 2014 Copyright GEDON Group</span>
        <span class="fl-r">Cделано в <a href="http://grapheme.ru" target="_blank">ГРАФЕМА</a></span>
    </div>
</footer>