<?php
    $channelCategory = ChannelCategory::where('slug','main-page-slider')->first();
    $products_slider = Channel::where('category_id',@$channelCategory->id)->orderBy('title')->with('images')->get();
?>
<div class="slider-container">
    <div class="slider-img toload"></div>
    <div class="wrapper slider-wrapper">
    @foreach($products_slider as $slide)
        <div class="slide-info toload">
            <div class="car-name">{{ $slide->title }}</div>
            <div class="car-desc">
                {{ $slide->short }}
            </div>
        </div>
    @endforeach
        <ul class="index-nav">
            <li class="option"><a href="#" class="js-pop-show" data-popup="call">Заказать<br>звонок</a>
            <li class="option"><a href="#" class="js-pop-show" data-popup="test-drive-models">Записаться<br>на тест-драйв</a>
            <li class="option"><a href="#" class="js-pop-show" data-popup="recover">Записаться<br>на сервис</a>
            <li class="option"><a href="#" class="js-pop-show" data-popup="items">Заказать<br>запчасти</a>
        </ul>
    </div>
    <div class="js-slider-nav">
    @foreach($products_slider as $slide)
        @if(File::exists(public_path('uploads/galleries/'.$slide->images->name)))
        <i data-thumb="{{ asset('uploads/galleries/thumbs/'.$slide->images->name) }}" data-img="{{ asset('uploads/galleries/'.$slide->images->name) }}"></i>
        @endif
    @endforeach
    </div>
    <div class="slider-nav-win" style="display: none;">
        <ul class="slider-nav"></ul>
    </div>
    <div class="slider-dots closed">
    </div>
</div>