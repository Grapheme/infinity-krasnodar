@extends(Helper::acclayout())
@section('style')
{{ HTML::style('css/redactor.css') }}
@stop
@section('content')
    <h1>Продукция: Цвет ({{ $product->meta->first()->title }})</h1>
{{ Form::model($complection, array('url'=>URL::route('product_complection_update',array('product_id'=>$product->id,'complection_id'=>$complection->id)), 'class'=>'smart-form', 'id'=>'product-complection-form', 'role'=>'form', 'method'=>'post')) }}
    <div class="row margin-top-10">
        <section class="col col-6">
            <div class="well">
                <header>Для изменения комплектации продукта отредактируйте форму:</header>
                <fieldset>
                    <section>
                        <label class="label">Название</label>
                        <label class="input"> <i class="icon-append fa fa-list-alt"></i>
                            {{ Form::text('title') }}
                        </label>
                    </section>
                    <section>
                        <label class="label">Цена</label>
                        <label class="input"> <i class="icon-append fa fa-list-alt"></i>
                            {{ Form::text('price') }}
                        </label>
                    </section>
                    @if (Allow::module('galleries'))
                    <section>
                        <label class="label">Изображение</label>
                        <label class="input">
                            {{ ExtForm::image('image', @$complection->images) }}
                        </label>
                    </section>
                    @endif
                    <section>
                        <label class="label">Описание</label>
                        <label class="textarea">
                            {{ Form::textarea('description',NULL,array('class'=>'redactor redactor_150')) }}
                        </label>
                    </section>
                    <section>
                        <label class="label">Динамика</label>
                        <label class="textarea">
                            {{ Form::textarea('dynamics',NULL,array('class'=>'redactor redactor_150')) }}
                        </label>
                    </section>
                    <section>
                        <label class="label">Экстерьер</label>
                        <label class="textarea">
                            {{ Form::textarea('exterior',NULL,array('class'=>'redactor redactor_150')) }}
                        </label>
                    </section>
                    <section>
                        <label class="label">Интерьер</label>
                        <label class="textarea">
                            {{ Form::textarea('interior',NULL,array('class'=>'redactor redactor_150')) }}
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
             <i class="fa fa-spinner fa-spin hidden"></i> <span class="btn-response-text">Изменить</span>
         </button>
     </footer>
    </section>
{{ Form::close() }}
@stop


@section('scripts')
    <script>
    var essence = 'product-complection';
    var essence_name = 'цвет продукта';
    var validation_rules = {
        title: { required: true },
        price: { required: true }
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