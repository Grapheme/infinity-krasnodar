@extends(Helper::layout())

@section('style')
@stop

@section('content')
@include('production/views/accepts/product-menu')
{{ $product->meta->first()->specifications }}
@stop
@section('scripts')
@stop