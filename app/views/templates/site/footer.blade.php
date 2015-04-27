<?php
    $footer_models = ProductCategory::with(array('product'=>function($query_product){
        $query_product->orderBy('order');
        $query_product->where('publication',1);
        #$query_product->where('in_menu',1);
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
</div>
<div id="carfinPrice"><!-- --></div>
<script type="text/javascript">
(function() {
   var carfinParam = {
       'partner': 608,
       'htmlPrice': 'carfinPrice',
       'positionAlign': 'left',
       'positionTop': 50,
       'tpl': 14
   };
   var carfinScript = document.createElement('script');
   carfinScript.type = 'text/javascript';
   carfinScript.async = true;
   carfinScript.charset = 'utf-8';
   carfinScript.src = (("https:" == document.location.protocol) ? "https://" : "http://") + 'car-fin.ru/widget/price.js';
   var carfinScriptDone = false;
   carfinScript.onload = carfinScript.onreadystatechange = function() {
       if (!carfinScriptDone
       && (!this.readyState || this.readyState == "loaded" || this.readyState == "complete")
       && typeof(carfinCalculator) == 'object') {
           carfinScriptDone = true;
           carfinCalculator.run(carfinParam);
       }
   }
   var firstScript = document.getElementsByTagName('script')[0];
   firstScript.parentNode.insertBefore(carfinScript, firstScript);
})();
</script>
<footer class="main-footer">
    <div class="footer-top">
        <div class="footer-left">
            <div class="footer-block">
                <div class="title">Модели</div>
                <ul class="footer-ul">
            @foreach($footer_models as $product_category)
                @foreach($product_category->product as $product)
                    @if($product->show_item)
                    <li class="option"><a href="{{ link::to(ProductionController::$prefix_url.'/'.$product->meta->first()->seo_url) }}">{{ substr($product->meta->first()->title,9)  }}</a>
                    @endif
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
                г. Краснодар,<br>
                ул. Горячеключевская, 5
            </adress>
            <div class="contact-block">
                <a href="tel:+78612001331" class="contact-link">+7 (861) 200-13-31</a>
            </div>
            <div class="soc-icons contact-block">
                <a href="https://www.facebook.com/infinitigedon" class="soc-link icon-fb"></a>
            </div>
            <div class="contact-block">
                <a href="http://infiniti.ru" target="_blank" class="typical-link">INFINITI в России</a>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="footer-bottom">
        <span>© 2014 Copyright GEDON Group</span>
        <span class="fl-r">Cделано в <a href="http://grapheme.ru" target="_blank">ГРАФЕМА</a></span>
    </div>
</footer>