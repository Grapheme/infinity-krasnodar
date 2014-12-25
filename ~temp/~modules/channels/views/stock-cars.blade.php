<?
$instocks = ProductInstock::orderBy('updated_at', 'DESC')
    ->with('image')
    ->with('product.meta')
    ->with('color.images')
    ->with('action')
    ->get();

#Helper::tad($instocks);

$models = array();


if (count($instocks)) {
    foreach ($instocks as $instock) {
        if (is_object($instock->product))
            $models[$instock->product->id] = $instock->product->meta[0]->title;
    }
}

#Helper::dd($models);

?>
<main>
    <section class="information buy-offer used">
        <header>
            <h1>
                Автомобили в наличии
            </h1>
        </header>

        <div class="cars-filter">
            <select class="customSelect selectModel filterSelectModel" data-filter-object-selector=".exist-table tbody">
                <option>Все модели</option>
                @foreach ($models as $m => $model)
                <option value="{{ $m }}" @if (Input::get('model') == $m) selected="selected" @endif)>{{ $model }}</option>
                @endforeach
            </select>

            <div class="founded">
                Найдено результатов: <span class="count-results">{{ count($instocks) }}</span>
            </div>
        </div>


        <table class="exist-table">
            <thead>
            <tr>
                <td colspan="2">Модель</td>
                <td>Двигатель / КПП</td>
                <td>Статус</td>
                <td>Акции</td>
                <td>Цена</td>
            </tr>
            </thead>
            <tbody>

            @foreach($instocks as $instock)
<?
$status = false;
if ($instock->status_id) {
$statuses = Config::get('site.instock_statuses');
$status = @$statuses[$instock->status_id];
}
$image = false;
if (@is_object($instock->image))
$image = $instock->image;
else if (@is_object($instock->color) && @is_object($instock->color->images))
$image = $instock->color->images;
?>
            <tr data-model-id="{{ is_object($instock->product) ? $instock->product->id : '' }}">
                <td>
                    <div class="car-photo" style="width:300px; height:200px; background-image: url({{ is_object($image) ? $image->thumb() : '' }})"></div>
                </td>
                <td>
                    <a href="{{ link::to(ProductionController::$prefix_url.'/'.$instock->product->meta->first()->seo_url) }}" class="car-name">
                        {{ $instock->title }}
                    </a>
                    <div class="car-desc">
                        @if (is_object($instock->color))
                        Цвет: {{ $instock->color->title }}<br>
                        @endif
                        @if ($instock->interior)
                        Салон: {{ $instock->interior }}<br>
                        @endif
                        @if ($instock->year)
                        Год: {{ $instock->year }} г.
                        @endif
                    </div>
                </td>
                <td>
                    <div class="car-desc">
                        {{ $instock->engine }}<br>
                        {{ $instock->transmission }}
                    </div>
                </td>
                <td>
                    <div class="car-desc">
                        {{ $status }}
                    </div>
                </td>
                <td>
                    <div class="car-desc">
                        @if (is_object($instock->action))
                        {{ $instock->action->title }}
                        @endif
                    </div>
                </td>
                <td>
                    <div class="car-price">
                        {{ $instock->price }}
                        @if (is_numeric($instock->price))
                        руб.
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach

            </tbody>
        </table>
    </section>
</main>