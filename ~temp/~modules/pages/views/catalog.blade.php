@extends(Helper::layout())
@section('style')

@stop

@section('content')
@include('production/views/catalog')
{{ $content }}
@stop
@section('scripts')

@stop