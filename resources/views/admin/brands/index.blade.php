@extends('admin.layouts.app')

@section('title')
{{ __('Brands') }}
@endsection

@section('css')
    
@endsection

@section('body')
    <div class="section-header">
        <h1>{{ __('Brands') }}</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h4>{{ __('Brands Table') }}</h4> <br>
                        <a href="{{ route('brands.create') }}" class="btn btn-success m-3"><i class="fa fa-plus"></i> {{ __('Add new brand') }}</a>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible show fade">
                          <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                              <span>&times;</span>
                            </button>
                            {{ __(session('status')) }}
                          </div>
                        </div>
                    @endif
                    <form action="{{ route('brands.destroy') }}" method="POST" id="deleteForm">
                        @csrf
                        {{ method_field('DELETE') }}
                        <button type="submit" onclick="
                        event.preventDefault();
                        if(confirm('{{ __('Are you sure you want to delete this row?') }}')) {
                            $(this).parent('form').submit();
                        }" class="btn btn-danger btn-lg" data-toggle="tooltip" data-placement="top" title="{{ __('Delete selected') }}"><i class="fa fa-times"></i> {{ __('Delete selected') }}</button>
                    </form>
                    <div class="table-responsive">
                    <table class="table table-striped" id="table-2">
                        <thead>
                        <tr>
                            <th class="text-center">
                            <div class="custom-checkbox custom-control">
                                <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input minimal" id="checkbox-all">
                                <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                            </div>
                            </th>
                            <th>{{ __('#') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Description') }}</th>
                            <th>{{ __('Category') }}</th>
                            <th>{{ __('Added from') }}</th>
                            <th>{{ __('Activate') }}</th>
                            <th>{{ __('Navbar visibility') }}</th>
                            <th>{{ __('Controls') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($brands as $brand)
                                <tr>
                                    <td>
                                        <div class="custom-checkbox custom-control">
                                            <input name="brands[]" form="deleteForm" type="checkbox" data-checkboxes="mygroup" class="custom-control-input" value="{{ $brand->id }}" id="checkbox-{{ $loop->index+1 }}">
                                            <label for="checkbox-{{ $loop->index+1 }}" class="custom-control-label">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $brand->name }}</td>
                                    <td>{!! $brand->description !!}</td>
                                    <td><a href="{{ route('categories.show', $brand->category_id) }}" class="badge badge-primary">{{ $brand->category->name }}</a></td>
                                    <td>{{ $brand->created_at->diffForHumans() }}</td>
                                    <td>
                                        <form action="{{ route('brands.active', $brand->id) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <label class="custom-switch mt-2" data-toggle="tooltip" data-placement="top" title="@if ($brand->active)
                                                {{ __('Active') }}
                                                @else
                                                {{ __('Not Active') }}
                                                @endif">
                                                <input name="active" value="{{ $brand->id }}" type="checkbox" @if ($brand->active)
                                                checked
                                                @endif class="custom-switch-input" onchange="
                                                    $(this).parent('form'),submit();
                                                ">
                                                <span class="custom-switch-indicator"></span>
                                            </label>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('brands.visibility', $brand->id) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <label class="custom-switch mt-2" data-toggle="tooltip" data-placement="top" title="@if ($brand->navbar_visibility)
                                                {{ __('Visible') }}
                                                @else
                                                {{ __('Not Visible') }}
                                                @endif">
                                                <input name="active" value="{{ $brand->id }}" type="checkbox" @if ($brand->navbar_visibility)
                                                checked
                                                @endif class="custom-switch-input" onchange="
                                                    $(this).parent('form'),submit();
                                                ">
                                                <span class="custom-switch-indicator"></span>
                                            </label>
                                        </form>
                                    </td>
                                    <td>
                                            <a href="{{ route('brands.edit', $brand->id) }}" data-toggle="tooltip" data-placement="top" title="{{ __('Edit') }}" class="btn btn-sm btn-warning">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                        <a href="{{ route('brands.show', $brand->id) }}" data-toggle="tooltip" data-placement="top" title="{{ __('View') }}" class="btn btn-sm btn-primary">
                                            <i class="fa fa-file"></i>
                                        </a>
                                            
                                            <a 
                                                href="#" 
                                                class="btn btn-danger btn-sm"
                                                onclick="
                                                        event.preventDefault();
                                                        if(confirm('{{ __('Are you sure you want to delete this row?') }}')) {
                                                            $(this).siblings('form').submit();
                                                        }" data-toggle="tooltip" data-placement="top" title="{{ __('Delete') }}"
                                            ><i class="fa fa-times"></i></a>
                                            <form action="{{ route('brands.destroy') }}" method="POST">
                                                @csrf
                                                {{ method_field('DELETE') }}
                                                <input type="hidden" name="brands[]" value="{{ $brand->id }}">
                                            </form>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection

@section('js')
    <!-- JS Libraies -->
    <script src="{{ asset('/admin_styles/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/admin_styles/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/admin_styles/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('/admin_styles/modules/jquery-ui/jquery-ui.min.js') }}"></script>

    <!-- Page Specific JS File -->
    
    @if (app()->isLocale('ar'))
        <script src="{{ asset('/admin_styles/js/page/modules-datatables-ar.js') }}"></script>
    @else
        <script src="{{ asset('/admin_styles/js/page/modules-datatables.js') }}"></script>
    @endif

@endsection