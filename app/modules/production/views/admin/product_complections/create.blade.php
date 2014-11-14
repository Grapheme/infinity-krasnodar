@extends(Helper::acclayout())
@section('style')
{{ HTML::style('css/redactor.css') }}
@stop
@section('content')
    <h1>Продукция: Новая комплектации ({{ $product->meta->first()->title }})</h1>
{{ Form::open(array('url'=>URL::route('product_complection_store',array('product_id'=>$product->id)), 'role'=>'form', 'class'=>'smart-form', 'id'=>'product-complection-form', 'method'=>'post')) }}
    <div class="row margin-top-10">
        <section class="col col-6">
            <div class="well">
                <header>Для создания новой комплектации продукта заполните форму:</header>
                <fieldset>
                    <section>
                        <label class="label">Название</label>
                        <label class="input"> <i class="icon-append fa fa-list-alt"></i>
                            {{ Form::text('title','') }}
                        </label>
                    </section>
                    <section>
                        <label class="label">Цена</label>
                        <label class="input"> <i class="icon-append fa fa-list-alt"></i>
                            {{ Form::text('price','') }}
                        </label>
                    </section>
                    @if (Allow::module('galleries'))
                    <section>
                        <label class="label">Изображение</label>
                        <label class="input">
                            {{ ExtForm::image('image', '') }}
                        </label>
                    </section>
                    @endif
                    <section>
                        <label class="label">Описание</label>
                        <label class="textarea">
                            {{ Form::textarea('description','',array('class'=>'redactor redactor_150')) }}
                        </label>
                    </section>
                    <section>
                        <label class="label">Динамика</label>
                        <label class="textarea">
                            {{ Form::textarea('dynamics','',array('class'=>'redactor redactor_150')) }}
                        </label>
                    </section>
                    <section>
                        <label class="label">Экстерьер</label>
                        <label class="textarea">
                            {{ Form::textarea('exterior','',array('class'=>'redactor redactor_150')) }}
                        </label>
                    </section>
                    <section>
                        <label class="label">Интерьер</label>
                        <label class="textarea">
                            {{ Form::textarea('interior','',array('class'=>'redactor redactor_150')) }}
                        </label>
                    </section>
                    <section>
                        <label class="label">Файл</label>
                        <label class="input input-file" for="file">
                            <div class="button"><input type="file" onchange="this.parentNode.nextSibling.value = this.value" name="file">Брошюра</div><input type="text" readonly="">
                        </label>
                    </section>
                </fieldset>
            </div>
        </section>
    </div>
    <div style="float:none; clear:both;"></div>
    @if(Allow::enabled_module('galleries') && 0)
    <section class="col-12">
        @include('modules.galleries.abstract')
        @include('modules.galleries.uploaded', array('gallery' => $gall))
    </section>
    @endif
    <section class="col-6">
        <footer>
            <a class="btn btn-default no-margin regular-10 uppercase pull-left btn-spinner" href="{{URL::previous()}}">
                <i class="fa fa-arrow-left hidden"></i> <span class="btn-response-text">Назад</span>
            </a>
            <button type="submit" autocomplete="off" class="btn btn-success no-margin regular-10 uppercase btn-form-submit">
                <i class="fa fa-spinner fa-spin hidden"></i> <span class="btn-response-text">Создать</span>
            </button>
        </footer>
    </section>
{{ Form::close() }}
@stop


@section('scripts')
    <script>
    var essence = 'product-complection';
    var essence_name = 'комлектация продукта';
	var validation_rules = {
		title: { required: true },
		price: { required: true },
	};
	var validation_messages = {
		title: { required: 'Укажите название' },
		price: { required: 'Укажите цену' },
	};
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
   {{ HTML::script('js/vendor/redactor.min.js') }}
   {{ HTML::script('js/system/redactor-config.js') }}
@stop