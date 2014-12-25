@extends(Helper::acclayout())


@section('content')

    <h1>Продукция: Галереи ({{ $product->meta->first()->title }})</h1>

    {{ Form::open(array('url' => URL::route('product_gallery_store', array('product_id' => $product->id)), 'role'=>'form', 'class' => 'smart-form', 'id' => 'product-gallery-form', 'method' => 'post')) }}

    <div class="row margin-top-10">
        <section class="col col-6">
            <div class="well">
                <header>К товару можно добавить 5 галерей:</header>
                <fieldset>
                @if (Allow::module('galleries'))

                    @for($i=0;$i<5;$i++)

                    <?
                    $gallery = isset($product_galleries[$i]) && is_object($product_galleries[$i]) && is_object($product_galleries[$i]->gallery)
                        ? $product_galleries[$i]
                        : new ProductGallery;
                    ?>

                    <section>
                        <label class="label">Галерея №{{ $i+1 }}</label>
                        <label class="textarea">
                            {{ ExtForm::gallery('gallery[' . $i . ']', $gallery->gallery, array('tpl' => 'extform_gallery_product')) }}
                        </label>
                        <label class="input">
                            {{ Form::text('title[' . $i . ']', $gallery->title, array('placeholder' => 'Заголовок')) }}
                        </label>
                        <label class="textarea">
                            {{ Form::textarea('desc[' . $i . ']', $gallery->desc, array('placeholder' => 'Описание')) }}
                        </label>
                    </section>

                    <br/><br/>

                    @endfor

                @endif
                </fieldset>

                <footer>
                    <a class="btn btn-default no-margin regular-10 uppercase pull-left btn-spinner" href="{{URL::previous()}}">
                        <i class="fa fa-arrow-left hidden"></i> <span class="btn-response-text">Назад</span>
                    </a>
                    <button type="submit" autocomplete="off" class="btn btn-success no-margin regular-10 uppercase btn-form-submit">
                        <i class="fa fa-spinner fa-spin hidden"></i> <span class="btn-response-text">Сохранить</span>
                    </button>
                </footer>

            </div>
        </section>
    </div>

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
