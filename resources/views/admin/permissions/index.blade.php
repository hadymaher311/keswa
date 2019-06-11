@extends('admin.layouts.app')

@section('title')
{{ __('Permissions') }}
@endsection

@section('css')
    
@endsection

@section('body')
    <div class="section-header">
        <h1>{{ __('Permissions') }}</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h4>{{ __('Permissions Table') }}</h4> <br>
                </div>
                <a href="{{ route('permissions.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> {{ __('Add new permission') }}</a>
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
                    <form action="{{ route('permissions.destroy') }}" method="POST" id="deleteForm">
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
                                <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
                                <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                            </div>
                            </th>
                            <th>{{ __('#') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Added from') }}</th>
                            <th>{{ __('Controls') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $permission)
                                <tr>
                                    <td>
                                        <div class="custom-checkbox custom-control">
                                            <input name="permissions[]" form="deleteForm" type="checkbox" data-checkboxes="mygroup" class="custom-control-input" value="{{ $permission->id }}" id="checkbox-{{ $loop->index+1 }}">
                                            <label for="checkbox-{{ $loop->index+1 }}" class="custom-control-label">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $permission->name }}</td>
                                    <td>{{ $permission->created_at->diffForHumans() }}</td>
                                    <td>
                                        <a href="{{ route('permissions.edit', $permission->id) }}" data-toggle="tooltip" data-placement="top" title="{{ __('Edit') }}" class="btn btn-sm btn-warning">
                                            <i class="fa fa-edit"></i>
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
                                        <form action="{{ route('permissions.destroy') }}" method="POST">
                                            @csrf
                                            {{ method_field('DELETE') }}
                                            <input type="hidden" name="permissions[]" value="{{ $permission->id }}">
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