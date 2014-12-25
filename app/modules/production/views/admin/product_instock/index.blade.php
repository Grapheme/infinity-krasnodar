@extends(Helper::acclayout())

@section('content')
    <h1>Автомобили в наличии - {{ $product->meta->first()->title }}</h1>
    <div class="row">
    	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-bottom-25 margin-top-10">
    		<div class="pull-left margin-right-10">
    		    <a class="btn btn-default" href="{{ link::auth('production/products') }}">К списку товаров</a>
    		@if(Allow::action('production', 'product_create'))
    			<a class="btn btn-primary" href="{{ URL::route('instock.create',array('product_id'=>$product->id) )}}">Добавить</a>
    		@endif
    		</div>
    	</div>
    </div>
    @if(count($instocks))
    <div class="row">
    	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
    		<table class="table table-striped table-bordered">
    			<thead>
    				<tr>
                        {{--<th class="col-lg-1 text-center">ID</th>--}}
    					<th class="col-lg-5 text-center" style="white-space:nowrap;">Название</th>
    					<th class="col-lg-5 text-center" style="white-space:nowrap;">Цена</th>
    					<th class="col-lg-1 text-center">Действия</th>
    				</tr>
    			</thead>
    			<tbody>
    			@foreach($instocks as $instock)
    				<tr class="vertical-middle">
                        {{--<td class="text-center">{{ $product->id }}</td>--}}
    					<td>
                            {{ $instock->title }}
                        </td>
                        <td>
                            {{ $instock->price }}
                        </td>
    					<td class="text-center" style="white-space:nowrap;">
        					@if(Allow::action($module['group'], 'product_edit'))
        					<a href="{{ URL::route('instock.edit',array('product_id'=>$product->id,'complection_id'=>$instock->id)) }}" class="btn btn-success margin-right-10">Изменить</a>
                    		@endif

        					@if(Allow::action($module['group'], 'product_delete'))
							<form method="POST" action="{{ URL::route('instock.destroy',array('product_id'=>$product->id,'instock_id'=>$instock->id)) }}" style="display:inline-block">
								<button type="submit" class="btn btn-danger remove-product-instock">Удалить</button>
							</form>
                    		@endif
    					</td>
    				</tr>
    			@endforeach
    			</tbody>
    		</table>
    	</div>
    </div>
    @else
    <div class="row">
    	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    		<div class="ajax-notifications custom">
    			<div class="alert alert-transparent">
    				<h4>Список пуст</h4>
    				В данном разделе находятся комплектации продуктов
    				<p><br><i class="regular-color-light fa fa-th-list fa-3x"></i></p>
    			</div>
    		</div>
    	</div>
    </div>
@endif

@stop


@section('scripts')
    <script>
    var essence = 'product-instock';
    var essence_name = 'авто в наличии';
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
