<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
 <head>
	@include('templates.site.head')
	@yield('style')
</head>
<body>
    <!--[if lt IE 7]>
    <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
        your browser</a> to improve your experience.</p>
    <![endif]-->
    @include('templates.site.header')
    <main>
    @yield('content', @$content)
    </main>
    @include('templates.site.footer')
    @include('templates.site.scripts')
    @yield('scripts')
    {{ HTML::script('theme/js/vendor/jquery.sumoselect.min.js') }}
    {{ HTML::script('theme/js/main.js') }}
    @yield('page_script')
</body>
</html>