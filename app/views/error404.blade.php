<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
 <head>
    @include('templates.site.head')
</head>
<body>
    <!--[if lt IE 7]>
    <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
        your browser</a> to improve your experience.</p>
    <![endif]-->
    @include('templates.site.header')
    <main>
        <div class="not-found">
            <div class="nf-block">
                <div class="nf-left">404</div>
                <div class="nf-right">
                    <div class="title">Ошибка</div>
                    <div class="desc">
                        Запрашиваемая вами страница<br>
                        не найдена. Вернитесь на <a href="{{URL::to('/')}}">главную</a><br>
                        страницу сайта
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('templates.site.scripts')
    {{ HTML::script('theme/js/vendor/jquery.sumoselect.min.js') }}
    {{ HTML::script('theme/js/main.js') }}
</body>
</html>