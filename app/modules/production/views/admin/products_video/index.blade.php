@extends(Helper::acclayout())
@section('content')
<h1>Продукция: Видео контент ({{ $product->meta->first()->title }})</h1>
{{ Form::model($videos,array('url'=>URL::route('product_video_store',array('product_id'=>$product->id)), 'role'=>'form', 'class'=>'smart-form', 'id'=>'product-video-form', 'method'=>'post')) }}
    <div class="row margin-top-10">
        <section class="col col-6">
            <div class="well">
                <header>К товару можно добавить 5 видео блоков:</header>
                <fieldset>
                 @for($i=0;$i<5;$i++)
                    <section>
                        <label class="label">Видео №{{ $i+1 }}</label>
                        <label class="textarea">
                            {{ Form::textarea('content['.($i+1).']',@$videos[$i]->content,array('class'=>'height-100')) }}
                        </label>
                    </section>
                     @endfor
                </fieldset>
            </div>
        </section>
    </div>
    <section class="col-6">
        <footer>
            <a class="btn btn-default no-margin regular-10 uppercase pull-left btn-spinner" href="{{URL::previous()}}">
                <i class="fa fa-arrow-left hidden"></i> <span class="btn-response-text">Назад</span>
            </a>
            <button type="submit" autocomplete="off" class="btn btn-success no-margin regular-10 uppercase btn-form-submit">
                <i class="fa fa-spinner fa-spin hidden"></i> <span class="btn-response-text">Сохранить</span>
            </button>
        </footer>
    </section>
{{ Form::close() }}
@stop

@section('scripts')
<script>
    var essence = 'product-video';
    var essence_name = 'видео';
	var validation_rules = {};
	var validation_messages = {};
    </script>

    {{ HTML::script('js/modules/standard.js') }}

	<script type="text/javascript">
		if(typeof pageSetUp === 'function'){pageSetUp();}
		if(typeof runFormValidation === 'function'){
			loadScript("{{ asset('js/vendor/jquery-form.min.js') }}", runFormValidation);
		}else{
			loadScript("{{ asset('js/vendor/jquery-form.min.js') }}");
		}
	</script>
@stop
