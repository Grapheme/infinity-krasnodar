@extends(Helper::layout())
@section('style')
@stop

@section('content')
 <section class="buy-offer used inf-block">
    <header>
        <h1>Автомобили с пробегом</h1>
        <div class="desc">
            {{ $content }}
        </div>
    </header>
    <?php
        $products = $accessories = $years = array();
        #if($all_products = Product::with('meta')->get()):
        $all_products = ChannelCategory::where('slug', 'car-for-sale')->with(array('channel' => function($query){
                $query->with(array('product' => function($query){
                        $query->with('meta');
                    }));
            }))->first();
        #Helper::tad($all_products);
        if(count($all_products->channel)):
            foreach($all_products->channel as $product):
                if (!$product->product)
                    continue;
                #$products[$product->id] = $product->meta->first()->title;
                $products[$product->product->id] = $product->product->meta[0]->title;
                $years[] = $product->year;
            endforeach;
            rsort($years);
        endif;
        $channelCategory = ChannelCategory::where('slug','car-for-sale')->first();
        $cars = Channel::where('category_id',@$channelCategory->id)->orderBy('title')->with('images')->get();
    ?>
    @if(count($products))
        <div class="cars-filter">
            @if (0)
            <select name="model" class="customSelect selectModel filterSelectModel" data-filter-object-selector=".sub-offers-ul">
                <option value="0">Все модели</option>
                @foreach($products as $product_id => $product_title)
                    <option value="{{ $product_id }}">{{ $product_title }}</option>
                @endforeach
            </select>
            @endif
            <select name="year" class="customSelect selectYear filterSelectYear" data-filter-object-selector=".sub-offers-ul">
                <option value="0">Все года</option>
            @foreach($years as $year)
                <option value="{{ $year }}">{{ $year }}</option>
            @endforeach
            </select>
            <div class="founded">
                Найдено результатов: <span class="count-results">{{ $cars->count() }}</span>
            </div>
        </div>
    @endif
    @include('channels/views/used-cars', compact('channelCategory', 'cars'))
    <div class="filterNoResults @if(count($products)) hidden @endif" style="padding: 10px 0px 40px;">
        Автомобилей с такими параметрами не найдено.
    </div>
</section>
@stop

@section('scripts')
@stop