@extends(Helper::layout())
@section('style')
{{ HTML::style('theme/css/sumoselect.css') }}
@stop

@section('content')
{{ $content }}
<section class="accessories sect-wrapper inf-block">
    <header>
        <h1>Аксессуары</h1>
    </header>
    <?php
        $products = $accessories = array();
        if($all_products = Product::with('meta')->get()):
            foreach($all_products as $product):
                $products[$product->id] = $product->meta->first()->title;
            endforeach;
        endif;
        $all_accessories = ProductAccessory::orderBy('title')->orderBy('price')->with('category')->with('accessibility')->with('images')->with('product')->get();

        if($all_accessories->count()):
            $categories = ProductAccessoryCategories::lists('title','id');
            $accessories = array();
            foreach ($categories as $category_id => $category_title):
                foreach ($all_accessories as $accessory):
                    if($accessory->category_id == $category_id):
                        $accessories[$category_title][] = $accessory;
                    endif;
                endforeach;
            endforeach;
        endif;
    ?>
@if(count($products))
    <div class="cars-filter">
        <select class="customSelect selectModel filterSelectModel" data-filter-object-selector=".acc-ul">
            <option value="0">Все модели</option>
        @foreach($products as $product_id => $product_title)
            <option value="{{ $product_id }}">{{ $product_title }}</option>
        @endforeach
        </select>
        <div class="founded">
            Найдено результатов: <span id="count-results" class="count-results">{{ $all_accessories->count() }}</span>
        </div>
    </div>
@endif
@if(count($accessories))
    <dl class="acc-dl">
        @foreach($accessories as $accessories_category_title => $accessories_category )
        <dt class="acc-dt"><h2>{{ $accessories_category_title }}</h2></dt>
            <dd class="acc-dd">
                <ul class="acc-ul">
                @foreach($accessories_category as $accessory )
                    <li data-model-id="{{ $accessory->product->id }}" class="acc-li clearfix">
                        @if(File::exists(public_path('uploads/galleries/thumbs/'.$accessory->images->name)))
                            <img class="acc-left" src="{{ asset('uploads/galleries/thumbs/'.$accessory->images->name) }}" alt="">
                        @endif
                        <div class="acc-right">
                            <h2>{{ $accessory->title }}</h2>
                            <div class="desc">
                                {{ $accessory->description }}
                            </div>
                            @if(!empty($accessory->price))
                            <div class="price">
                                {{ $accessory->price }}
                            </div>
                            @endif
                            <div class="availability">
                                {{ $accessory->accessibility->title }}
                            </div>
                        </div>
                    </li>
                @endforeach
                </ul>
            </dd>
        @endforeach
    </dl>
@endif
</section>
@stop
@section('scripts')
{{ HTML::script("theme/js/vendor/jquery.sumoselect.min.js") }}
<script>
    $('.customSelect.selectModel').SumoSelect({placeholder: 'Модель'});
</script>
@stop