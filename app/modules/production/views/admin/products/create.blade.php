@extends(Helper::acclayout())
@section('style')
{{ HTML::style('css/redactor.css') }}
{{ HTML::style('css/redactor.css') }}
@stop
@section('content')
    <h1>Продукция: Новый продукт</h1>
{{ Form::open(array('url'=>link::auth($module['rest'].'/store'), 'role'=>'form', 'class'=>'smart-form', 'id'=>'product-form', 'method'=>'post')) }}
	<div class="well">
        <header>Для создания нового продукта заполните форму:</header>
        <fieldset>
            <section>
                <label class="label">Категория</label>
                <label class="select">
                    {{ Form::select('category_id', $categories, ($cat > 0 ? $cat : '' ) ) }}
                </label>
            </section>
        </fieldset>
    </div>
    <ul class="nav nav-tabs margin-top-10">
        @foreach ($locales as $l => $locale)
        <li class="{{ $l === 0 ? 'active' : '' }}">
            <a href="#lang_{{ $locale }}" data-toggle="tab">{{ $locale }}</a>
        </li>
        @endforeach
    </ul>
	<div class="row margin-top-10">
        <div class="tab-content">
            @foreach ($locales as $l => $locale)
            <div class="tab-pane{{ $l === 0 ? ' active' : '' }}" id="lang_{{ $locale }}">
                <!-- Form -->
                <section class="col col-6">
                    <div class="well">
                        <header>{{ $locale }}-версия:</header>
                        <fieldset>
                            <section>
                                <label class="label">Название</label>
                                <label class="input"> <i class="icon-append fa fa-list-alt"></i>
                                    {{ Form::text('title['.$locale.']','') }}
                                </label>
                            </section>
                            <section>
                                <label class="label">Короткое название</label>
                                <label class="input"> <i class="icon-append fa fa-list-alt"></i>
                                    {{ Form::text('short_title['.$locale.']','') }}
                                </label>
                            </section>
                            <section>
                                <label class="label">Цена</label>
                                <label class="input"> <i class="icon-append fa fa-money"></i>
                                    {{ Form::text('price['.$locale.']','') }}
                                </label>
                            </section>
                            @if (Allow::module('galleries'))
                            <section>
                                <label class="label">Изображение</label>
                                <label class="input">
                                    {{ ExtForm::image('image', '') }}
                                </label>
                            </section>
                            <section>
                                <label class="label">Изображение в меню</label>
                                <label class="input">
                                    {{ ExtForm::image('menu_image', '') }}
                                </label>
                            </section>
                            <section>
                                <label class="label">Галерея</label>
                                <label class="input">
                                    {{ ExtForm::gallery('gallery','',array('id'=>'gallery-input-id', 'tpl' => 'extform_gallery_product')) }}
                                </label>
                            </section>
                            @endif
                            <section>
                                <label class="label">Краткое описание</label>
                                <label class="textarea">
                                    {{ Form::textarea('preview['.$locale.']','',array('class'=>'redactor redactor_150')) }}
                                </label>
                            </section>
                            <section>
                                <label class="label">Описание</label>
                                <label class="textarea">
                                    {{ Form::textarea('content['.$locale.']','',array('class'=>'redactor redactor_450')) }}
                                </label>
                            </section>
                            <section>
                                <label class="label">Характеристики</label>
                                <label class="textarea">
                                    {{ Form::textarea('specifications['.$locale.']','',array('class'=>'redactor redactor_450')) }}
                                </label>
                            </section>
                            <section>
                                <label class="label">Брошюра</label>
                                <label class="input input-file" for="file">
                                    <div class="button"><input type="file" onchange="this.parentNode.nextSibling.value = this.value" name="file">Выбрать</div><input type="text" readonly="">
                                </label>
                            </section>
                            <section>
                                <label class="checkbox">
                                    {{ Form::checkbox('in_menu',1,true) }}
                                    <i></i>Показывать товар в главном меню
                                </label>
                            </section>
                            <section>
                                <label class="checkbox">
                                    {{ Form::checkbox('show_item',1,true) }}
                                    <i></i>Доступен для просмотра
                                </label>
                            </section>
                            <section>
                                <label class="label">Описание в выпадающем меню</label>
                                <label class="textarea">
                                    {{ Form::textarea('menu_content['.$locale.']','',array('class'=>'redactor redactor_150')) }}
                                </label>
                            </section>
                            <?php
                                $models = ProductCategory::orderby('id')->with(array('product'=>function($query_product){
                                    $query_product->with(array('meta'=>function($query_product_meta){
                                        $query_product_meta->orderBy('title');
                                    }));
                                }))->get();
                            ?>
                            @if($models->count())
                            <section>
                                <label for="h-input">Связанные продукты</label>
                                <select style="width:100%" name="related[]" class="related-production" multiple>
                                @foreach($models as $model_category)
                                    @if($model_category->product->count())
                                    <optgroup label="{{ $model_category->title }}">
                                    @foreach($model_category->product as $related_product)
                                    <option value="{{ $related_product->id }}">{{ $related_product->meta->first()->title }}</option>
                                    @endforeach
                                    </optgroup>
                                    @endif
                                @endforeach
                                </select>
                            </section>
                            @endif
                        </fieldset>
                    </div>
                </section>
                @if(Allow::enabled_module('seo'))
                <section class="col col-6">
                    <div class="well">
                        @include('modules.seo.events')
                    </div>
                </section>
                @endif
            </div>
            @endforeach
        </div>
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
    var essence = 'product';
    var essence_name = 'продукт';
	var validation_rules = {
		category_id: { required: true, min: 1 },
	};
	var validation_messages = {
		category_id: { required: 'Укажите категорию', min: 'Укажите категорию' },
	};
    </script>

    {{ HTML::script('js/modules/standard.js') }}
    {{ HTML::script('js/plugin/select2/select2.min.js') }}
	<script type="text/javascript">

	    $(".related-production").select2({
            placeholder: "Выбирите модель",
	    });

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