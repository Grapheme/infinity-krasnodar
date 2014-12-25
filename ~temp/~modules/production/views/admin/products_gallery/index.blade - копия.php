@extends(Helper::acclayout())


@section('content')
<h1>Продукция: Галереи ({{ $product->meta->first()->title }})</h1>
{{ Form::model($galleries, array('url' => URL::route('product_gallery_store', array('product_id' => $product->id)), 'role'=>'form', 'class' => 'smart-form', 'id' => 'product-gallery-form', 'method' => 'post')) }}
    <div class="row margin-top-10">
        <section class="col col-6">
            <div class="well">
                <header>К товару можно добавить 5 галерей:</header>
                <fieldset>
                @if (Allow::module('galleries'))
                    @for($i=0;$i<5;$i++)

                    <section>
                        <label class="label">Галерея №{{ $i+1 }}</label>
                        <label class="textarea">
                            {{ ExtForm::gallery('gallery_'.($i), @$galleries[$i], array('id'=>'gallery-input-'.($i))) }}
                        </label>
                        <label class="input">
                            {{ Form::text('title[' . $i . ']', null, array('placeholder' => 'Заголовок')) }}
                        </label>
                        <label class="textarea">
                            {{ Form::textarea('desc[' . $i . ']', null, array('placeholder' => 'Описание')) }}
                        </label>
                    </section>

                    <br/><br/>

                     @endfor
                @endif
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
    var essence = 'product-gallery';
    var essence_name = 'галерея';
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

	 {{ HTML::script('js/modules/gallery.js') }}
@stop
