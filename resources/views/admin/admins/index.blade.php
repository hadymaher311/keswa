@extends('admin.layouts.app')

@section('title')
{{ __('Admins') }}
@endsection

@section('css')
    
@endsection

@section('body')
    <div class="section-header">
        <h1>{{ __('Admins') }}</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h4>{{ __('Admins Table') }}</h4> <br>
                        <a href="{{ route('admins.create') }}" class="btn btn-success m-3"><i class="fa fa-plus"></i> {{ __('Add new admin') }}</a>
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
                        <form action="{{ route('admins.destroy') }}" method="POST" id="deleteForm">
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
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Role') }}</th>
                            <th>{{ __('Added from') }}</th>
                            <th>{{ __('Active') }}</th>
                            <th>{{ __('Controls') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($admins as $admin)
                                <tr>
                                    <td>
                                        <div class="custom-checkbox custom-control">
                                            <input name="admins[]" form="deleteForm" type="checkbox" data-checkboxes="mygroup" class="custom-control-input" value="{{ $admin->id }}" id="checkbox-{{ $loop->index+1 }}">
                                            <label for="checkbox-{{ $loop->index+1 }}" class="custom-control-label">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>
                                        @if ($admin->image)
                                            <img src="{{ $admin->image->getUrl('thumb') }}" alt="" class="img-fluid" style="max-width: 50px; border-radius: 100%">
                                        @endif 
                                        {{ $admin->name }}
                                    </td>
                                    <td>{{ $admin->email }}</td>
                                    <td>{{ ($admin->roles->first()) ? $admin->roles->first()->name : '' }}</td>
                                    <td>{{ $admin->created_at->diffForHumans() }}</td>
                                    
                                    <td>
                                            <form action="{{ route('admins.active', $admin->id) }}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <label class="custom-switch mt-2" data-toggle="tooltip" data-placement="top" title="@if ($admin->active)
                                                    {{ __('Active') }}
                                                    @else
                                                    {{ __('Not Active') }}
                                                    @endif">
                                                    <input name="active" value="{{ $admin->id }}" type="checkbox" @if ($admin->active)
                                                    checked
                                                    @endif class="custom-switch-input" onchange="
                                                        $(this).parent('form'),submit();
                                                    ">
                                                    <span class="custom-switch-indicator"></span>
                                                </label>
                                        </form>
                                    </td>

                                    <td>
                                            <a href="{{ route('admins.edit', $admin->id) }}" data-toggle="tooltip" data-placement="top" title="{{ __('Edit') }}" class="btn btn-sm btn-warning">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        
                                        <a href="{{ route('admins.edit.password', $admin->id) }}" data-toggle="tooltip" data-placement="top" title="{{ __('Edit password') }}" class="btn btn-sm btn-dark">
                                            <i class="fa fa-lock"></i>
                                        </a>
                                            
                                        <a href="{{ route('admins.show', $admin->id) }}" data-toggle="tooltip" data-placement="top" title="{{ __('View') }}" class="btn btn-sm btn-primary">
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
                                            <form action="{{ route('admins.destroy') }}" method="POST">
                                                @csrf
                                                {{ method_field('DELETE') }}
                                                <input type="hidden" name="admins[]" value="{{ $admin->id }}">
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