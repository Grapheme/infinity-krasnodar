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
                        г. Краснодар,<br>
                        ул. Горячеключевская, 5
                    </address>
                </div>
                <div>
                    <h2>Телефон</h2>
                    <a href="tel:+78612001331">+7 (861) 200-13-31</a>
                </div>
                <div>
                    <h2>Email</h2>
                    <a href="mailto:Kr.infiniti@gedon.ru">Kr.infiniti@gedon.ru</a>
                </div>
            </div>
            <div class="mid">
                <div>
                    <h2>
                        Режим работы
                    </h2>
                    <div class="desc">
                        Пн–Пт с 9.00 до 20.00<br>
                        Сб–Вс с 9.00 до 18.00
                    </div>
                </div>
                <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script><div id="gmap_canvas" class="map" style="height:380px;width:480px;"></div><style>#gmap_canvas img{max-width:none!important;background:none!important}</style><script type="text/javascript"> function init_map(){var myOptions = {zoom:14,center:new google.maps.LatLng(45.005101, 39.107661),mapTypeId: google.maps.MapTypeId.TERRAIN};map = new google.maps.Map(document.getElementById("gmap_canvas"), myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(45.005101, 39.107661)});infowindow = new google.maps.InfoWindow({content:"г. Краснодар, ул. Горячеключевская, 5" });google.maps.event.addListener(marker, "click", function(){infowindow.open(map,marker);});infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);</script>
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