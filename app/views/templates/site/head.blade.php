<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>{{{(isset($page_title))?$page_title:Config::get('app.default_page_title')}}}</title>
<meta name="description" content="{{{(isset($page_description))?$page_description:''}}}">
{{ HTML::style('theme/css/normalize.css') }}
{{ HTML::style('theme/css/main.css') }}
{{ HTML::style('theme/css/sumoselect.css') }}
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
@if(Config::get("app.use_googlefonts"))
<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600&subset=cyrillic,latin' rel='stylesheet' type='text/css'>
@endif
{{ HTML::script('js/vendor/modernizr-2.6.2.min.js') }}

{{ HTML::style('theme/css/sumoselect.css') }}
