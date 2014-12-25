@extends(Helper::layout())

@section('style')

@stop

@section('content')
    <section class="contacts sect-wrapper inf-block">
        <header>
            <h1>Контакты</h1>
            <div class="desc">
                {{ $content }}
            </div>
        </header>
        <div class="contact-wrapper clearfix">
            <div class="left">
                <div>
                    <h2>Адрес</h2>
                    <address>
                        346715, г. Ростовская обл.,<br>
                        Аксайский р-н, п. Янтарный,<br>
                        Новочеркасское шоссе, 16В
                    </address>
                </div>
                <div>
                    <h2>Телефон</h2>
                    <a href="tel:+78632928892">+7 863 292-88-92</a>
                    <a href="tel:+78633050500">+7 863 305-05-00</a>
                </div>
                <div>
                    <h2>Отдел продаж</h2>
                    <a href="+78632928892">+7 863 292-88-92</a>
                </div>
                <div>
                    <h2>Email</h2>
                    <a href="mailto:infiniti-info@gedon.ru">infiniti-info@gedon.ru</a>
                </div>
            </div>
            <div class="mid">
                <div>
                    <h2>
                        Режим работы
                    </h2>
                    <div class="desc">
                        Пн-Сб 9.00-20.00<br>
                        Вс 9.00-19.00
                    </div>
                </div>
                <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script><div id="gmap_canvas" class="map" style="height:380px;width:480px;"></div><style>#gmap_canvas img{max-width:none!important;background:none!important}</style><script type="text/javascript"> function init_map(){var myOptions = {zoom:14,center:new google.maps.LatLng(47.274166, 39.830086),mapTypeId: google.maps.MapTypeId.TERRAIN};map = new google.maps.Map(document.getElementById("gmap_canvas"), myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(47.274166, 39.830086)});infowindow = new google.maps.InfoWindow({content:"<b>Infiniti</b><br/>&#1075;. &#1056;&#1086;&#1089;&#1090;&#1086;&#1074;-&#1085;&#1072;-&#1044;&#1086;&#1085;&#1091;, &#1040;&#1082;&#1089;&#1072;&#1081;&#1089;&#1082;&#1080;&#1081; &#1088;-&#1085;,<br>&#1087;. &#1071;&#1085;&#1090;&#1072;&#1088;&#1085;&#1099;&#1081;, &#1053;&#1086;&#1074;&#1086;&#1095;&#1077;&#1088;&#1082;&#1072;&#1089;&#1089;&#1082;&#1086;&#1077; &#1096;&#1086;&#1089;&#1089;&#1077;, 16&#1042; <br/> " });google.maps.event.addListener(marker, "click", function(){infowindow.open(map,marker);});infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);</script>
            </div>
            <div class="right">
                <h2>Форма обратной связи</h2>
                {{ Form::open(array('url'=>URL::route('contact_feedback'),'role'=>'form','class'=>'smart-form','id'=>'contact-feedback-form','method'=>'post')) }}
                    <fieldset>
                        <section>
                            <input class="input" type="text" name="fio" placeholder="Ф.И.О.">
                        </section>
                        <section>
                            <input class="input" type="text" name="email" placeholder="Email или телефон">
                        </section>
                        {{--
                        <section>
                            <input class="input" type="text" name="phone" placeholder="Телефон">
                        </section>
                        --}}
                        <section>
                            <textarea class="textarea" name="content" placeholder="Ваш вопрос"></textarea>
                        </section>
                    </fieldset>
                    <footer>
                        <button type="submit" autocomplete="off" class="btn medium btn-form-submit">
                            <i class="fa fa-spinner fa-spin hidden"></i> <span class="btn-response-text">Отправить</span>
                        </button>
                    </footer>
                {{ Form::close() }}
            </div>
        </div>
    </section>
@stop
@section('scripts')

@stop