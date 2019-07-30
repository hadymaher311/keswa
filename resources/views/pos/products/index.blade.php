@extends('pos.layouts.app')

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
                    <div class="table-responsive">
                    <table class="table table-striped" id="table-2">
                        <thead>
                        <tr>
                            <th>{{ __('#') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Total Quantity') }}</th>
                            <th>{{ __('Price') }}</th>
                            <th>{{ __('Added from') }}</th>
                            <th>{{ __('Active') }}</th>
                            <th>{{ __('Discount') }}</th>
                            <th>{{ __('Free shipping') }}</th>
                            <th>{{ __('Has points') }}</th>
                            <th>{{ __('Controls') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->getWarehouseQuantity(auth()->user()->warehouse_id) }} {{ __(ucfirst($product->sale_by)) }}</td>
                                    <td>
                                        @if ($product->activeDiscount)
                                            <div class="col-9">
                                                <span style="text-decoration: line-through">{{ $product->price }} {{ __('LE') }}</span>&nbsp;&nbsp;&nbsp;&nbsp;
                                                <span class="{{ ($product->final_price <= $product->cost) ? 'badge badge-danger' : '' }}">{{ $product->final_price }} {{ __('LE') }}</span>
                                            </div>
                                        @else
                                            <div class="col-9 {{ ($product->final_price <= $product->cost) ? 'badge badge-danger' : '' }}">
                                                {{ $product->final_price }} {{ __('LE') }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $product->created_at->diffForHumans() }}</td>
                                    <td>
                                        @if ($product->active)
                                            <div class="badge badge-success">{{ __('Active') }}</div>
                                        @else
                                            <div class="badge badge-danger">{{ __('Not Active') }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($product->activeDiscount)
                                            <div class="badge badge-success">{{ __('Has discount') }}</div>
                                        @else
                                            <div class="badge badge-danger">{{ __('No discount for this product') }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($product->free_shipping)
                                            <div class="badge badge-success">{{ __('Free shipping') }}</div>
                                        @else
                                            <div class="badge badge-danger">{{ __('No free shipping') }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($product->allow_points)
                                            <div class="badge badge-success">{{ __('Has points') }}</div>
                                        @else
                                            <div class="badge badge-danger">{{ __('Has no points') }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('pos_products.show', $product->id) }}" data-toggle="tooltip" data-placement="top" title="{{ __('View') }}" class="btn btn-sm btn-primary">
                                            <i class="fa fa-file"></i>
                                        </a>
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