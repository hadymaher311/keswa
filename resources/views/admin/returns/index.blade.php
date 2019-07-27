@extends('admin.layouts.app')

@section('title')
{{ __('Returns') }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('/admin_styles/modules/bootstrap-daterangepicker/daterangepicker.css') }}">    
<link rel="stylesheet" href="{{ asset('/admin_styles/modules/izitoast/css/iziToast.min.css') }}">
@endsection

@section('body')
    <div class="section-header">
        <h1>{{ __('Returns') }}</h1>
    </div>


    <div class="section-body">

        <div class="row">
            <div class="col-12">
                <div class="card mb-0">
                    <div class="card-body">
                        <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('returns.index') }}?state=pending">{{ __('Pending') }} <span class="badge badge-dark">{{ $pending_returns_count }}</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('returns.index') }}?state=by_date">{{ __('By date') }} <span class="badge badge-dark"></span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('returns.index') }}?state=all">{{ __('All') }} <span class="badge badge-dark">{{ $all_returns_count }}</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('returns.index') }}?state=approved">{{ __('Approved') }} <span class="badge badge-dark">{{ $approved_returns_count }}</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('returns.index') }}?state=disapproved">{{ __('Disapproved') }} <span class="badge badge-dark">{{ $disapproved_returns_count }}</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('returns.index') }}?state=in_the_way">{{ __('In the way') }} <span class="badge badge-dark">{{ $in_the_way_returns_count }}</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('returns.index') }}?state=return_denied">{{ __('Return denied') }} <span class="badge badge-dark">{{ $return_denied_returns_count }}</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('returns.index') }}?state=completed">{{ __('Completed') }} <span class="badge badge-dark">{{ $completed_returns_count }}</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('returns.index') }}?state=completed_scrapped">{{ __('Completed scrapped') }} <span class="badge badge-dark">{{ $completed_scrapped_returns_count }}</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('returns.index') }}?state=canceled">{{ __('Canceled') }} <span class="badge badge-dark">{{ $canceled_returns_count }}</span></a>
                        </li>
                        </ul>
                    </div>
                </div>
            </div>
            @if (Request::get('state') == 'by_date')
            <div class="col-12">
                <div class="card">
                    <form action="{{ route('returns.index') }}" id="date-form" method="get">
                        <input type="hidden" name="state" value="by_date">
                        <div class="form-group row pl-5 pr-5">
                            <label class="col-sm-3 control-label" for="input-date-of-birth">{{ __('From - To') }} <span class="date-input">({{ implode(' / ', explode('/', Request::get('from_to'))) }})</span></label>
                            <div class="col-sm-3">
                                <input type="text" class="d-none date-input" name="from_to" required autocomplete="from_to" placeholder="{{ __('From - To') }}" id="input-date-of-birth" class="form-control">
                                <a href="javascript:;" class="btn btn-block btn-warning daterange-btn icon-left btn-icon"><i class="fas fa-calendar"></i> {{ __('Choose Date') }}
                                </a>
                            </div>
                            <div class="col-sm-3">
                                <button type="submit" class="btn btn-warning btn-block">{{ __('Submit') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>

        <div class="row mt-4">
            <div class="col-12">

                <div class="card">
                <div class="card-header">
                    <h4>{{ __('Returns Table') }}</h4> <br>
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
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible show fade">
                          <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                              <span>&times;</span>
                            </button>
                            {{ __(session('error')) }}
                          </div>
                        </div>
                    @endif
                    <form action="{{ route('returns.destroy') }}" method="POST" id="deleteForm">
                        @csrf
                        {{ method_field('DELETE') }}
                        <button type="submit" onclick="
                        event.preventDefault();
                        if(confirm('{{ __('Are you sure you want to delete this row?') }}')) {
                            $(this).parent('form').submit();
                        }" class="btn btn-danger mb-3" data-toggle="tooltip" data-placement="top" title="{{ __('Delete selected') }}"><i class="fa fa-times"></i> {{ __('Delete selected') }}</button>
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
                            <th>{{ __('Return ID') }}</th>
                            <th>{{ __('Product') }}</th>
                            <th>{{ __('Quantity') }}</th>
                            <th>{{ __('Order') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('User') }}</th>
                            <th>{{ __('Added from') }}</th>
                            <th>{{ __('Approve') }}</th>
                            <th>{{ __('Shipping') }}</th>
                            <th>{{ __('Completed') }}</th>
                            <th>{{ __('Controls') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($returns as $return)
                                <tr>
                                    <td>
                                        <div class="custom-checkbox custom-control">
                                            <input name="returns[]" form="deleteForm" type="checkbox" data-checkboxes="mygroup" class="custom-control-input" value="{{ $return->id }}" id="checkbox-{{ $loop->index+1 }}">
                                            <label for="checkbox-{{ $loop->index+1 }}" class="custom-control-label">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>#{{ $return->id }}</td>
                                    <td>
                                        <a href="{{ route('products.show', $return->product->id) }}">{{ $return->product->name }}</a>
                                    </td>
                                    <td>{{ $return->quantity }}</td>
                                    <td>
                                        <a href="{{ route('orders.show', $return->order->id) }}">#{{ $return->order->id }}</a>
                                    </td>
                                    @php
                                        $return_status = $return->statuses->last()->name;
                                    @endphp
                                    <td>@include('admin.components.returnStatusColor')</td>
                                    <td>
                                        <a href="{{ route('users.show', $return->user->id) }}">{{ ucfirst($return->user->first_name) . ' ' . ucfirst($return->user->last_name) }}</a>
                                    </td>
                                    <td>{{ $return->created_at }}</td>
                                    <td>
                                        @if ($return->isInTheWay())
                                            @if ($return->isApproved())
                                                <button data-toggle="tooltip" data-placement="top" title="{{ __('Approved') }}" class="btn btn-sm btn-success">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                            @elseif ($return->isDisapproved())
                                                <button data-toggle="tooltip" data-placement="top" title="{{ __('Disapproved') }}" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            @endif
                                        @else
                                        @if ($return->isApproved())
                                                <a href="{{ route('returns.approve', $return->id) }}" data-toggle="tooltip" data-placement="top" title="{{ __('Approved') }}" class="btn btn-sm btn-success">
                                                    <i class="fa fa-check"></i>
                                                </a>
                                            @elseif ($return->isDisapproved())
                                                <a href="{{ route('returns.approve', $return->id) }}" data-toggle="tooltip" data-placement="top" title="{{ __('Disapproved') }}" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('returns.approve', $return->id) }}" data-toggle="tooltip" data-placement="top" title="{{ __('Approve') }}" data-id="{{ $return->id }}" class="btn btn-sm btn-warning model-5">
                                                    <i class="fa fa-check"></i>
                                                </a>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if ($return->isApproved() && !$return->isCanceled() && !$return->isCompleted() && !$return->isShippingReturned())
                                            <a href="{{ route('returns.shippingForm', $return->id) }}" data-toggle="tooltip" data-placement="top" title="{{ __('Shipping') }}" class="btn btn-sm btn-info">
                                                <i class="fa fa-shipping-fast"></i>
                                            </a>
                                            @if ($return->isInTheWay())
                                                <form action="{{ route('returns.shipping.returned', $return->id) }}" method="POST" class="form-inline" style="display: inline">
                                                    @csrf
                                                    <button data-toggle="tooltip" data-placement="top" title="{{ __('Shipping returned') }}" class="btn btn-sm btn-danger">
                                                        <i class="fa fa-shipping-fast"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if ($return->isApproved() && !$return->isCanceled() && $return->isInTheWay() && !$return->isShippingReturned())
                                            @if ($return->isCompleted())
                                                <button data-toggle="tooltip" data-placement="top" title="{{ __('Completed') }}" class="btn btn-sm btn-success">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                            @else
                                                <form action="{{ route('returns.complete', $return->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" data-toggle="tooltip" data-placement="top" title="{{ __('Complete') }}" class="btn btn-sm btn-warning">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @can('update returns')
                                            @if (!$return->isCanceled() && !$return->isInTheWay() && !$return->isDisapproved())
                                                <a href="{{ route('returns.edit', $return->id) }}" data-toggle="tooltip" data-placement="top" title="{{ __('Edit') }}" class="btn btn-sm btn-warning">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endif
                                        @endcan

                                        <a href="{{ route('returns.invoice', $return->id) }}" data-toggle="tooltip" data-placement="top" title="{{ __('Invoice') }}" class="btn btn-sm btn-info">
                                            <i class="fa fa-file-pdf"></i>
                                        </a>

                                        <a href="{{ route('returns.show', $return->id) }}" data-toggle="tooltip" data-placement="top" title="{{ __('View') }}" class="btn btn-sm btn-primary">
                                            <i class="fa fa-file"></i>
                                        </a>

                                        @can('delete returns')
                                            @if (!$return->isCanceled() && !$return->isInTheWay() && !$return->isDisapproved())
                                                <a 
                                                    href="#" 
                                                    class="btn btn-danger btn-sm"
                                                    onclick="
                                                            event.preventDefault();
                                                            if(confirm('{{ __('Are you sure you want to delete this row?') }}')) {
                                                                $(this).siblings('form').submit();
                                                            }" data-toggle="tooltip" data-placement="top" title="{{ __('Delete') }}"
                                                ><i class="fa fa-times"></i></a>
                                                <form action="{{ route('returns.destroy') }}" method="POST">
                                                    @csrf
                                                    {{ method_field('DELETE') }}
                                                    <input type="hidden" name="returns[]" value="{{ $return->id }}">
                                                </form>
                                            @endif
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
    <script src="{{ asset('/admin_styles/modules/izitoast/js/iziToast.min.js') }}"></script>
    <!-- Page Specific JS File -->
    
    @if (app()->isLocale('ar'))
        <script src="{{ asset('/admin_styles/js/page/modules-datatables-ar.js') }}"></script>
    @else
        <script src="{{ asset('/admin_styles/js/page/modules-datatables.js') }}"></script>
    @endif
    <script src="{{ asset('/admin_styles/modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    <script>

        $('.daterange-btn').daterangepicker({
            ranges: {
                "{{ __('Today') }}"       : [moment(), moment().add(1, 'days')],
                "{{ __('Yesterday') }}"   : [moment().subtract(1, 'days'), moment()],
                "{{ __('Last 7 Days') }}" : [moment().subtract(6, 'days'), moment().add(1, 'days')],
                "{{ __('Last 30 Days') }}": [moment().subtract(29, 'days'), moment().add(1, 'days')],
                "{{ __('This Month') }}"  : [moment().startOf('month'), moment().endOf('month')],
                "{{ __('Last Month') }}"  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            startDate: moment().subtract(2, 'days'),
            endDate  : moment()
            }, function (start, end) {
            $('#date-form input.date-input').val(start.format('DD-MM-YYYY') + '/' + end.format('DD-MM-YYYY'))
            $('#date-form span.date-input').text(start.format('DD-MM-YYYY') + ' / ' + end.format('DD-MM-YYYY'))
        });
    </script>

@endsection