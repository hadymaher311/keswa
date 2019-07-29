<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" @if (app()->isLocale('ar')) dir="rtl" @endif>
	@include('pos.layouts.head')
<body>
	<div id="app">
		<div class="text-auto main-wrapper main-wrapper-1">
			@include('pos.layouts.navbar')
			@include('pos.layouts.sidenavbar.sidenavbar')
			<div class="main-content">
				<section class="section">
					@section('body')
						@show
				</section>
			</div>
			@include('pos.layouts.footer')
		</div>
	</div>
		@include('pos.layouts.js')
</body>
</html>