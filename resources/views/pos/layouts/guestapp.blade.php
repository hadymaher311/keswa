<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" @if (app()->isLocale('ar')) dir="rtl" @endif>
	@include('pos.layouts.head')
<body>
	<div id="app">
		@section('body')
			@show
	</div>
	@include('pos.layouts.js')
</body>
</html>