@extends('admin.layouts.app')

@section('title')
{{ __('Products') }}
@endsection

@section('css')
    
@endsection

@section('body')
    <div class="section-header">
        <h1>{{ __('Products') }}</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h4>{{ __('Products Table') }}</h4> <br>
                    @can('create products')
                        <a href="{{ route('products.create') }}" class="btn btn-success m-3"><i class="fa fa-plus"></i> {{ __('Add new product') }}</a>
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
                    @can('delete products')
                        <form action="{{ route('products.destroy') }}" method="POST" id="deleteForm">
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
                            <th>{{ __('Quantity') }}</th>
                            <th>{{ __('Price') }}</th>
                            <th>{{ __('Added from') }}</th>
                            <th>{{ __('Activate') }}</th>
                            <th>{{ __('Activate discount') }}</th>
                            <th>{{ __('Allow reviews') }}</th>
                            <th>{{ __('Free shipping') }}</th>
                            <th>{{ __('Controls') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>
                                        <div class="custom-checkbox custom-control">
                                            <input name="products[]" form="deleteForm" type="checkbox" data-checkboxes="mygroup" class="custom-control-input" value="{{ $product->id }}" id="checkbox-{{ $loop->index+1 }}">
                                            <label for="checkbox-{{ $loop->index+1 }}" class="custom-control-label">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->created_at->diffForHumans() }}</td>
                                    <td>
                                        @can('update products')
                                            <form action="{{ route('products.active', $product->id) }}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <label class="custom-switch mt-2" data-toggle="tooltip" data-placement="top" title="@if ($product->active)
                                                    {{ __('Active') }}
                                                    @else
                                                    {{ __('Not Active') }}
                                                    @endif">
                                                    <input name="active" value="{{ $product->id }}" type="checkbox" @if ($product->active)
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
                                        @can('update products')
                                            @if ($product->discount)
                                                <form action="{{ route('products.discount.active', $product->id) }}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <label class="custom-switch mt-2" data-toggle="tooltip" data-placement="top" title="@if ($product->discount->active)
                                                        {{ __('Active') }}
                                                        @else
                                                        {{ __('Not Active') }}
                                                        @endif">
                                                        <input name="active" value="{{ $product->id }}" type="checkbox" @if ($product->discount->active)
                                                        checked
                                                        @endif class="custom-switch-input" onchange="
                                                            $(this).parent('form'),submit();
                                                        ">
                                                        <span class="custom-switch-indicator"></span>
                                                    </label>
                                                </form>
                                            @else
                                                {{ __('No discount for this product') }}
                                            @endif
                                        @endcan
                                    </td>
                                    <td>
                                        @can('update products')
                                            <form action="{{ route('products.allow.reviews', $product->id) }}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <label class="custom-switch mt-2" data-toggle="tooltip" data-placement="top" title="@if ($product->allow_review)
                                                    {{ __('Allowed') }}
                                                    @else
                                                    {{ __('Not Allowed') }}
                                                    @endif">
                                                    <input name="active" value="{{ $product->id }}" type="checkbox" @if ($product->allow_review)
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
                                        @can('update products')
                                            <form action="{{ route('products.free.shipping', $product->id) }}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <label class="custom-switch mt-2" data-toggle="tooltip" data-placement="top" title="@if ($product->free_shipping)
                                                    {{ __('Free') }}
                                                    @else
                                                    {{ __('Not Free') }}
                                                    @endif">
                                                    <input name="active" value="{{ $product->id }}" type="checkbox" @if ($product->free_shipping)
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
                                        @can('update products')
                                            <a href="{{ route('products.edit', $product->id) }}" data-toggle="tooltip" data-placement="top" title="{{ __('Edit') }}" class="btn btn-sm btn-warning">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            
                                            <a href="{{ route('products.images.edit', $product->id) }}" data-toggle="tooltip" data-placement="top" title="{{ __('Edit images') }}" class="btn btn-sm btn-dark">
                                                <i class="fa fa-image"></i>
                                            </a>
                                        @endcan
                                        
                                        <a href="{{ route('products.show', $product->id) }}" data-toggle="tooltip" data-placement="top" title="{{ __('View') }}" class="btn btn-sm btn-primary">
                                            <i class="fa fa-file"></i>
                                        </a>
                                            
                                        @can('delete products')
                                            <a 
                                                href="#" 
                                                class="btn btn-danger btn-sm"
                                                onclick="
                                                        event.preventDefault();
                                                        if(confirm('{{ __('Are you sure you want to delete this row?') }}')) {
                                                            $(this).siblings('form').submit();
                                                        }" data-toggle="tooltip" data-placement="top" title="{{ __('Delete') }}"
                                            ><i class="fa fa-times"></i></a>
                                            <form action="{{ route('products.destroy') }}" method="POST">
                                                @csrf
                                                {{ method_field('DELETE') }}
                                                <input type="hidden" name="products[]" value="{{ $product->id }}">
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