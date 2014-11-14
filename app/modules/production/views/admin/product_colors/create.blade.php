@extends(Helper::acclayout())
@section('style')

@stop
@section('content')
    <h1>Продукция: Новый цвет ({{ $product->meta->first()->title }})</h1>
{{ Form::open(array('url'=>URL::route('product_color_store',array('product_id'=>$product->id)), 'role'=>'form', 'class'=>'smart-form', 'id'=>'product-color-form', 'method'=>'post')) }}
    <div class="row margin-top-10">
        <section class="col col-6">
            <div class="well">
                <header>Для добавления нового цвета продукта заполните форму:</header>
                <fieldset>
                    <section>
                        <label class="label">Название</label>
                        <label class="input"> <i class="icon-append fa fa-list-alt"></i>
                            {{ Form::text('title','') }}
                        </label>
                    </section>
                    <section>
                        <label class="label">Код цвета</label>
                        <label class="input"> <i class="icon-append fa fa-list-alt"></i>
                            {{ Form::text('color','') }}
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
    var essence = 'product-color';
    var essence_name = 'цвет продукта';
	var validation_rules = {
		title: { required: true },
		color: { required: true }
	};
	var validation_messages = {
		title: { required: 'Укажите название' },
		color: { required: 'Укажите код цвета' },
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
@stop