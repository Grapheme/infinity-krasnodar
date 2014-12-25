@extends(Helper::acclayout())
@section('style')
{{ HTML::style('css/redactor.css') }}
@stop
@section('content')
    <h1>Изменить автомобиль в наличии - {{ $product->meta->first()->title }}</h1>
{{ Form::model($instock, array('url'=>URL::route('instock.update',array('product_id'=>$product->id,'instock_id'=>$instock->id)), 'class'=>'smart-form', 'id'=>'product-instock-form', 'role'=>'form', 'method'=>'PUT')) }}
    <div class="row margin-top-10">
        <section class="col col-6">
            <div class="well">
                <header>Для изменения авто в наличии отредактируйте форму:</header>
                <fieldset>

                    <section>
                        <label class="label">Название</label>
                        <label class="input"> <i class="icon-append fa fa-list-alt"></i>
                            {{ Form::text('title') }}
                        </label>
                    </section>

                    @if (Allow::module('galleries'))
                    <section>
                        <label class="label">Изображение</label>
                        <label class="input">
                            {{ ExtForm::image('image_id') }}
                        </label>
                    </section>
                    @endif

                    <section>
                        <label class="label">Цвет</label>
                        <label class="select">
                            {{ Form::select('color_id', array('Выберите...')+$colors->lists('title', 'id')) }}
                        </label>
                    </section>

                    <section>
                        <label class="label">Салон</label>
                        <label class="input"> <i class="icon-append fa fa-list-alt"></i>
                            {{ Form::text('interior') }}
                        </label>
                    </section>

                    <section>
                        <label class="label">Год</label>
                        <label class="input"> <i class="icon-append fa fa-list-alt"></i>
                            {{ Form::text('year') }}
                        </label>
                    </section>

                    <section>
                        <label class="label">Двигатель</label>
                        <label class="input"> <i class="icon-append fa fa-list-alt"></i>
                            {{ Form::text('engine') }}
                        </label>
                    </section>

                    <section>
                        <label class="label">КПП</label>
                        <label class="input"> <i class="icon-append fa fa-list-alt"></i>
                            {{ Form::text('transmission') }}
                        </label>
                    </section>

                    <section>
                        <label class="label">Статус</label>
                        <label class="select">
                            {{ Form::select('status_id', array('Выберите...')+Config::get('site.instock_statuses')) }}
                        </label>
                    </section>

                    <?
                    #Helper::dd( ChannelCategory::where('slug', 'offer')->first()->channel->lists('title', 'id') );
                    ?>

                    <section>
                        <label class="label">Акция</label>
                        <label class="select">
                            {{ Form::select('action_id', array('Выберите...')+ChannelCategory::where('slug', 'offer')->first()->channel->lists('title', 'id')) }}
                        </label>
                    </section>

                    <section>
                        <label class="label">Цена</label>
                        <label class="input"> <i class="icon-append fa fa-list-alt"></i>
                            {{ Form::text('price') }}
                        </label>
                    </section>

                </fieldset>
            </div>
        </section>
    </div>

    <div style="float:none; clear:both;"></div>

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
    var essence = 'product-instock';
    var essence_name = 'авто в наличии';
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