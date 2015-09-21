@extends(Helper::layout())
@section('style')
<style type="text/css">
	.slider-link{
		display: inline-block;
		color: #FFF !important;
		/*border: 2px solid #FFF;*/
		background-color: #613f7e;
		padding: 0 .9375rem;
		line-height: 3.3125rem;
		text-decoration: none;
		margin-top: 20px;
		text-shadow: none;
		/*box-shadow: 2px 2px 4px rgba(0,0,0,0.75);*/
	}

	.slider-link:hover {
		background-color: rgba(97, 63, 126, 0.8);
	}
</style>
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