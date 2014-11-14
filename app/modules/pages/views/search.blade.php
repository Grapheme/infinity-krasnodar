@extends(Helper::layout())
@section('style')

@stop

@section('content')


{{ $content }}
@include('sphinxsearch/views/result')
@stop
@section('page_script')
@stop