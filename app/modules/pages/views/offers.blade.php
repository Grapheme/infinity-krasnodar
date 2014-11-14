@extends(Helper::layout())
@section('style')

@stop

@section('content')
{{ $content }}
@include('channels/views/offers')
@stop
@section('scripts')

@stop