@extends(Helper::layout())


@section('style')

@stop


@section('content')
{{ $content }}
@include('channels/views/stock-cars')
@stop


@section('scripts')
@if (Input::get('model') && is_numeric(Input::get('model')))
<script>
    //filterModel({{ Input::get('model') }});
</script>
@endif
@stop