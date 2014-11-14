@extends(Helper::acclayout())
@section('style')
{{ HTML::style('css/redactor.css') }}
@stop
@section('content')
    <h1>Продукция: Аксессуар ({{ $product->meta->first()->title }})</h1>
{{ Form::model($accessory, array('url'=>URL::route('product_accessory_update',array('product_id'=>$product->id,'accessory_id'=>$accessory->id)), 'class'=>'smart-form', 'id'=>'product-accessory-form', 'role'=>'form', 'method'=>'post')) }}
    <div class="row margin-top-10">
        <section class="col col-6">
            <div class="well">
                <header>Для изменения аксессуара продукта отредактируйте форму:</header>
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
                     <section>
                        <label class="label">Категория</label>
                        <label class="select">
                            {{ Form::select('category_id', ProductAccessoryCategories::lists('title','id'),$accessory->category_id) }}
                        </label>
                    </section>
                    <section>
                        <label class="label">Доступность</label>
                        <label class="select">
                            {{ Form::select('accessibility_id', ProductAccessoryAccessibility::lists('title','id'),$accessory->accessibility_id) }}
                        </label>
                    </section>
                    @if (Allow::module('galleries'))
                    <section>
                        <label class="label">Изображение</label>
                        <label class="input">
                            {{ ExtForm::image('image', @$accessory->images) }}
                        </label>
                    </section>
                    @endif
                    <section>
                        <label class="label">Описание</label>
                        <label class="textarea">
                            {{ Form::textarea('description',NULL,array('class'=>'redactor redactor_150')) }}
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
    var essence = 'product-accessory';
    var essence_name = 'аксессуар продукта';
    var validation_rules = {
        title: { required: true },
    };
    var validation_messages = {
        title: { required: 'Укажите название' },
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