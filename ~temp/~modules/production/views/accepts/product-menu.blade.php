<?
    $route = Route::currentRouteName();
?>

<div class="model-menu">
   <div class="model-options">
       <span class="model-name">{{ $product->meta->first()->short_title }}</span>
       <a href="{{ link::to(ProductionController::$prefix_url.'/'.$product->meta->first()->seo_url) }}" class="model-option @if($route == 'single_product') active @endif">Обзор</a>
       <a href="{{ link::to(ProductionController::$prefix_url.'/'.$product->meta->first()->seo_url.'/specifications') }}" class="model-option @if($route == 'specifications_product') active @endif">Характеристики</a>
       <a href="{{ link::to(ProductionController::$prefix_url.'/'.$product->meta->first()->seo_url.'/galleries') }}" class="model-option @if($route == 'galleries_product') active @endif">Галерея</a>
       <a href="{{ link::to(ProductionController::$prefix_url.'/'.$product->meta->first()->seo_url.'/complections') }}" class="model-option @if($route == 'complections_product') active @endif">Комплектации и цены</a>
       <a href="{{ link::to(ProductionController::$prefix_url.'/'.$product->meta->first()->seo_url.'/accessories') }}" class="model-option @if($route == 'accessories_product') active @endif">Аксессуары</a>
   </div><!--
 --><div class="model-right">
		@if($instocks_count = $product->instocks->count())<span class="model-exist"><a href="{{ link::to(@$pages_seo_url['cars-in-stock']->seo_url.'?model=' . $product->id) }}" class="model-option">{{ $instocks_count }} {{ $product->meta->first()->title }} в наличии</a></span>@endif<!--
	 -->@if(!empty($product->brochure) && File::exists(public_path($product->brochure)))<a href="{{ asset($product->brochure) }}" target="_blank" class="broshure-link" download><span class="icon icon-bricks"></span><span class="text">Брошюра</span></a>@endif
 	</div>
</div>