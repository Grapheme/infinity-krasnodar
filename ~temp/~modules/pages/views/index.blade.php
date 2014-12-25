@extends(Helper::layout())
@section('style')

@stop

@section('content')
@include('channels/views/index-slider')
{{ $content }}
@stop
@section('page_script')
	<script>
		$('.slider-container').slider(true);
	</script>
@stop