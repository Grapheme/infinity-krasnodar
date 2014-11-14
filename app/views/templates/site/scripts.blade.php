@if(Config::get('app.use_scripts_local'))
	{{HTML::script('js/vendor/jquery.min.js');}}
@else
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="{{asset('js/vendor/jquery.min.js');}}"><\/script>')</script>
@endif

	{{HTML::script('js/system/main.js');}}
	{{HTML::script('js/vendor/SmartNotification.min.js');}}
	{{HTML::script('js/vendor/jquery.validate.min.js');}}
	{{HTML::script('js/system/app.js');}}
	{{HTML::script('js/system/messages.js');}}

	{{HTML::script('theme/js/plugins.js');}}
	<script type="text/javascript">
		if(typeof runFormValidation === 'function'){
			loadScript("{{asset('js/vendor/jquery-form.min.js');}}",runFormValidation);
		}else{
			loadScript("{{asset('js/vendor/jquery-form.min.js');}}");
		}
	</script>


    {{ HTML::script("theme/js/vendor/jquery.sumoselect.min.js") }}
    <script>
        $('.customSelect.selectModel').SumoSelect({placeholder: 'Модель'});
        $('.customSelect.selectYear').SumoSelect({placeholder: 'Год'});
    </script>


	{{HTML::script('theme/js/app.js');}}

    <style>
    .state-error input, .state-error select, .state-error textarea, .state-error .CaptionCont {
        border: 1px solid #633E7C !important;
        background-color: #E9D9F3 !important;
    }
    em.invalid {
        display: none !important;
    }
    </style>