@extends('admin.layouts.app')

@section('title')
{{ __('Sub categories') }}
@endsection

@section('css')
    
@endsection

@section('body')
    <div class="section-header">
        <h1>{{ __('Sub categories') }}</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h4>{{ __('Sub categories Table') }}</h4> <br>
                    @can('create sub_categories')
                        <a href="{{ route('sub_categories.create') }}" class="btn btn-success m-3"><i class="fa fa-plus"></i> {{ __('Add new sub category') }}</a>
                    @endcan
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
                    @can('delete sub_categories')
                        <form action="{{ route('sub_categories.destroy') }}" method="POST" id="deleteForm">
                            @csrf
                            {{ method_field('DELETE') }}
                            <button type="submit" onclick="
                            event.preventDefault();
                            if(confirm('{{ __('Are you sure you want to delete this row?') }}')) {
                                $(this).parent('form').submit();
                            }" class="btn btn-danger mb-3" data-toggle="tooltip" data-placement="top" title="{{ __('Delete selected') }}"><i class="fa fa-times"></i> {{ __('Delete selected') }}</button>
                        </form>
                    @endcan
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
                            <th>{{ __('Main Category') }}</th>
                            <th>{{ __('Added from') }}</th>
                            <th>{{ __('Activate') }}</th>
                            <th>{{ __('Navbar visibility') }}</th>
                            <th>{{ __('Controls') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($sub_categories as $sub_category)
                                <tr>
                                    <td>
                                        <div class="custom-checkbox custom-control">
                                            <input name="sub_categories[]" form="deleteForm" type="checkbox" data-checkboxes="mygroup" class="custom-control-input" value="{{ $sub_category->id }}" id="checkbox-{{ $loop->index+1 }}">
                                            <label for="checkbox-{{ $loop->index+1 }}" class="custom-control-label">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $sub_category->name }}</td>
                                    <td>{!! $sub_category->description !!}</td>
                                    <td><a href="{{ route('categories.show', $sub_category->category_id) }}" class="badge badge-primary">{{ $sub_category->main_category->name }}</a></td>
                                    <td>{{ $sub_category->created_at->diffForHumans() }}</td>
                                    <td>
                                        @can('update sub_categories')
                                            <form action="{{ route('sub_categories.active', $sub_category->id) }}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <label class="custom-switch mt-2" data-toggle="tooltip" data-placement="top" title="@if ($sub_category->active)
                                                    {{ __('Active') }}
                                                    @else
                                                    {{ __('Not Active') }}
                                                    @endif">
                                                    <input name="active" value="{{ $sub_category->id }}" type="checkbox" @if ($sub_category->active)
                                                    checked
                                                    @endif class="custom-switch-input" onchange="
                                                        $(this).parent('form'),submit();
                                                    ">
                                                    <span class="custom-switch-indicator"></span>
                                                </label>
                                            </form>
                                        @endcan
                                    </td>
                                    <td>
                                        @can('update sub_categories')
                                            <form action="{{ route('sub_categories.visibility', $sub_category->id) }}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <label class="custom-switch mt-2" data-toggle="tooltip" data-placement="top" title="@if ($sub_category->navbar_visibility)
                                                    {{ __('Visible') }}
                                                    @else
                                                    {{ __('Not Visible') }}
                                                    @endif">
                                                    <input name="active" value="{{ $sub_category->id }}" type="checkbox" @if ($sub_category->navbar_visibility)
                                                    checked
                                                    @endif class="custom-switch-input" onchange="
                                                        $(this).parent('form'),submit();
                                                    ">
                                                    <span class="custom-switch-indicator"></span>
                                                </label>
                                            </form>
                                        @endcan
                                    </td>
                                    <td>
                                        @can('update sub_categories')
                                            <a href="{{ route('sub_categories.edit', $sub_category->id) }}" data-toggle="tooltip" data-placement="top" title="{{ __('Edit') }}" class="btn btn-sm btn-warning">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        @endcan
                                        
                                        <a href="{{ route('sub_categories.show', $sub_category->id) }}" data-toggle="tooltip" data-placement="top" title="{{ __('View') }}" class="btn btn-sm btn-primary">
                                            <i class="fa fa-file"></i>
                                        </a>
                                            
                                        @can('delete sub_categories')
                                            <a 
                                                href="#" 
                                                class="btn btn-danger btn-sm"
                                                onclick="
                                                        event.preventDefault();
                                                        if(confirm('{{ __('Are you sure you want to delete this row?') }}')) {
                                                            $(this).siblings('form').submit();
                                                        }" data-toggle="tooltip" data-placement="top" title="{{ __('Delete') }}"
                                            ><i class="fa fa-times"></i></a>
                                            <form action="{{ route('sub_categories.destroy') }}" method="POST">
                                                @csrf
                                                {{ method_field('DELETE') }}
                                                <input type="hidden" name="sub_categories[]" value="{{ $sub_category->id }}">
                                            </form>
                                        @endcan
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