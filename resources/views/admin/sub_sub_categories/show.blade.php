@extends('admin.layouts.app')

@section('title')
{{ __('View sub sub category') }}
@endsection

@section('css')
    
@endsection

@section('body')
    <div class="section-header">
        <h1>{{ __('Sub sub categories') }}</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h4>{{ __('View sub sub category') }}</h4> <br>
                    @can('create sub_categories')
                        <a href="{{ route('sub_categories.create') }}" class="btn btn-success m-3"><i class="fa fa-plus"></i> {{ __('Add new sub sub category') }}</a>
                    @endcan
                    @can('update sub_categories')
                        <a href="{{ route('sub_categories.edit', $sub_sub_category->id) }}" class="btn btn-warning m-3"><i class="fa fa-edit"></i> {{ __('Edit') }}</a>
                    @endcan
                    <a href="{{ route('sub_categories.index') }}" class="btn btn-primary m-3"><i class="fa fa-home"></i> {{ __('Back to all') }}</a>
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

                    <div class="row">
                        <div class="col-md-4">
                            @if ($sub_sub_category->image)
                                <div class=" text-center">
                                    <img alt="image" src="{{ $sub_sub_category->image->getUrl('card') }}" class="border img-fluid">
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-sm-3"><b>{{ __('Name') }}:</b></div>
                                <div class="col-sm-9">
                                    {{ $sub_sub_category->name }}
                                    @if ($sub_sub_category->active)
                                        <div class="badge badge-success" style="padding: 7px 12px; font-size: 12px;">{{ __('Active') }}</div>
                                        @else
                                        <div class="badge badge-danger" style="padding: 7px 12px; font-size: 12px;">{{ __('Not Active') }}</div>
                                    @endif
                                </div>
                                <div class="col-sm-3"><b>{{ __('Description') }}:</b></div>
                                <div class="col-sm-9">{!! $sub_sub_category->description !!}</div>
                                <div class="col-sm-3"><b>{{ __('Category') }}:</b></div>
                                <div class="col-sm-9">
                                    <a href="{{ route('sub_categories.show', $sub_sub_category->sub_category_id) }}" class="badge badge-primary">{{ $sub_sub_category->sub_category->name }}</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>

@endsection

@section('js')
@endsection