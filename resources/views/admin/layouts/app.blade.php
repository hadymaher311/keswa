<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	@include('admin.layouts.head')
<body class="hold-transition skin-orange sidebar-mini">
	<!-- Site wrapper -->
	<div class="wrapper">
		@include('admin.layouts.navbar')
		@include('admin.layouts.sidenavbar')
		<div class="content-wrapper">
			@section('body')
				@show
		</div>
		@include('admin.layouts.footer')
	</div>
		@include('admin.layouts.js')
</body>
</html>