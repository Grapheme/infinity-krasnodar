@extends(Helper::acclayout())


@section('style')
    <link rel="stylesheet" href="{{ link::path('css/redactor.css') }}" />
@stop


@section('content')
    <h1>Информационные блоки: &laquo;{{ $channel->title }}&raquo;</h1>

{{ Form::model($channel, array('url'=>link::auth($module['rest'].'/update/'.$channel->id), 'class'=>'smart-form', 'id'=>'channel-form', 'role'=>'form', 'method'=>'post','files'=>true)) }}
	<div class="row margin-top-10">
		<section class="col col-6">
			<div class="well">
				<header>Для изменения элемента отредактируйте форму:</header>
				<fieldset>
                    <section>
                        <label class="label">Порядковый номер</label>
                        <label class="input">
                            {{ Form::text('order') }}
                        </label>
                    </section>
					<section>
						<label class="label">Название</label>
						<label class="input">
							{{ Form::text('title') }}
						</label>
					</section>

                    <section>
                        <label class="label">Ссылка</label>
                        <label class="input">
                            {{ Form::text('link') }}
                        </label>
                        <div class="note">Относительная ссылка если в предалах сайта или полная если это другой сайт</div>
                    </section>

					<section>
						<label class="label">Категория</label>
						<label class="select">
							{{ Form::select('category_id', $categories) }}
						</label>
					</section>

					<?php
                       $products = array();
                       if($all_products = Product::with('meta')->get()):
                           foreach($all_products as $product):
                               $products[$product->id] = $product->meta->first()->title;
                           endforeach;
                       endif;
                    ?>
                    <section>
                        <label class="label">Связан с продуктом</label>
                        <label class="select">
                            <select name="product_id" class="customSelect selectModel">
                                <option value="0">Без модели</option>
                            @foreach($products as $product_id => $product_title)
                                <option {{ $channel->product_id == $product_id ? 'selected' : '' }} value="{{ $product_id }}">{{ $product_title }}</option>
                            @endforeach
                            </select>
                        </label>
                    </section>
                    <section>
                        <label class="label">Цена</label>
                        <label class="input">
                            {{ Form::text('price') }}
                        </label>
                    </section>
                    <section>
                        <label class="label">Год выпуска</label>
                        <label class="input">
                            {{ Form::text('year') }}
                        </label>
                    </section>
                    @if(Allow::module('templates') || 1)
                    <section>
                        <label class="label">Шаблон:</label>
                        <label class="select col-5">
                            {{ Form::select('template', $templates,NULL, array('class'=>'template-change','autocomplete'=>'off')) }} <i></i>
                        </label>
                    </section>
                    @endif
                    @if (Allow::module('galleries'))
                    <section>
                        <label class="label">Изображение</label>
                        <label class="input">
                            {{ ExtForm::image('image', @$channel->photo()) }}
                        </label>
                    </section>
                   <section>
                       <label class="label">Галерея</label>
                       <label class="input">
                           {{ ExtForm::gallery('gallery',@$channel->gallery,array('id'=>'gallery-input-id')) }}
                       </label>
                   </section>
                    @endif

					<section>
						<label class="label">Краткое описание</label>
						<label class="textarea">
							{{ Form::textarea('short',NULL,array('class'=>'redactor redactor_150')) }}
						</label>
					</section>
                    <section>
                        <label class="label">Описание</label>
                        <label class="textarea">
                            {{ Form::textarea('desc',NULL,array('class'=>'redactor')) }}
                        </label>
                    </section>
                    <section>
                        <label class="label">Файл</label>
                        <label class="input input-file" for="file">
                            <div class="button"><input type="file" onchange="this.parentNode.nextSibling.value = this.value" name="file">Выбрать</div><input type="text" readonly="">
                        </label>
                        @if(!empty($channel->file))
                        <div class="note">
                            <strong>Внимание!</strong> Документ загружен ранее
                        </div>
                        @endif
                    </section>
				</fieldset>
				<footer>
					<a class="btn btn-default no-margin regular-10 uppercase pull-left btn-spinner" href="{{ URL::previous() }}">
						<i class="fa fa-arrow-left hidden"></i> <span class="btn-response-text">Назад</span>
					</a>
					<button type="submit" autocomplete="off" class="btn btn-success no-margin regular-10 uppercase btn-form-submit">
						<i class="fa fa-spinner fa-spin hidden"></i> <span class="btn-response-text">Изменить</span>
					</button>
				</footer>
			</div>
		</section>
	</div>
{{ Form::close() }}
@stop


@section('scripts')
    <script>
    var essence = 'channel';
    var essence_name = 'элемент';
	var validation_rules = {
		title: { required: true },
		category_id: { required: true, min: 1 },
		//desc: { required: true },
	};
	var validation_messages = {
		title: { required: 'Укажите название' },
		category_id: { required: 'Укажите категорию', min: 'Укажите категорию' },
		//desc: { required: 'Укажите описание' },
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