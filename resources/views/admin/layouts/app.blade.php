<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" @if (app()->isLocale('ar')) dir="rtl" @endif>
	@include('admin.layouts.head')
<body>
	<div id="app">
		<div class="text-auto main-wrapper main-wrapper-1">
			@include('admin.layouts.navbar')
			@include('admin.layouts.sidenavbar')
			<div class="main-content">
				<section class="section">
					@section('body')
						@show
				</section>
			</div>
			@include('admin.layouts.footer')
		</div>
	</div>
		@include('admin.layouts.js')
</body>
</html>