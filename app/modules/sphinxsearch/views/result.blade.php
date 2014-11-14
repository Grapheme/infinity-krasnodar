<?php
if (Input::has('query')):
    $result = SphinxsearchController::search(Input::get('query'));
    $totalCount = (int) count($result['channels']) + (int) count($result['products'])+ (int) count($result['accessories']) + (int) count($result['news']) + (int) count($result['pages']);
endif;
?>

<section class="buy-offer used inf-block">
    <header>
        <h1>Результаты поиска</h1>
    </header>
    <div class="cars-filter">
        <input class="search-inp" value="{{ Input::get('query') }}">
        <div class="founded">Найдено результатов: <span>{{ $totalCount }}</span></div>
    </div>
</section>
<section>
    <ul class="search-results">
    @if($result['products'] && count($result['products']))
        @foreach($result['products'] as $product)
        <li>
            <div class="inf-block">
                <a href="{{ link::to(ProductionController::$prefix_url.'/'.$product->seo_url) }}" class="title">{{ $product->title }}</a>
                <div class="desc">{{ Str::words(strip_tags($product->preview), 100, ' ...') }}</div>
            </div>
        @endforeach
    @endif
    @if($result['channels'] && count($result['channels']))
        @foreach($result['channels'] as $channel)
        <li>
            <div class="inf-block">
                <a href="{{ link::to('offer/'.$channel->link) }}" class="title">{{ $channel->title }}</a>
                <div class="desc">{{ Str::words(strip_tags($channel->desc), 100, ' ...') }}</div>
            </div>
        @endforeach
    @endif
    @if($result['news'] && count($result['news']))
        @foreach($result['news'] as $news)
        <li>
            <div class="inf-block">
                <a href="javascript:void(0);" class="title">{{ $news->title }}</a>
                <div class="desc">{{ Str::words(strip_tags($news->preview), 100, ' ...') }}</div>
            </div>
        @endforeach
    @endif
    @if($result['pages'] && count($result['pages']))
        @foreach($result['pages'] as $page)
        <li>
            <div class="inf-block">
                <a href="{{ link::to($page->seo_url) }}" class="title">{{ $page->name }}</a>
                <div class="desc">{{ Str::words(strip_tags($page->content), 100, ' ...') }}</div>
            </div>
        @endforeach
    @endif
    @if($result['accessories'] && count($result['accessories']))
        @foreach($result['accessories'] as $accessory)
        <li>
            <div class="inf-block">
                <a href="{{ link::to(ProductionController::$prefix_url.'/'.$accessory->product->meta->first()->seo_url.'/accessories#'.$accessory->id) }}" class="title">{{ $accessory->title }}</a>
                <div class="desc">{{ Str::words(strip_tags($accessory->description), 100, ' ...') }}</div>
            </div>
        @endforeach
    @endif
    </ul>
</section>