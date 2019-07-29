<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" @if (app()->isLocale('ar')) dir="rtl" @endif>
	@include('admin.layouts.head')
<body>
	<div id="app">
		@section('body')
			@show
	</div>
	@include('admin.layouts.js')
</body>
</html>