@extends('admin.layouts.app')

@section('title')
{{ __('View sub category') }}
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
                    <h4>{{ __('View sub category') }}</h4> <br>
                    @can('create sub_categories')
                        <a href="{{ route('sub_categories.create') }}" class="btn btn-success m-3"><i class="fa fa-plus"></i> {{ __('Add new sub category') }}</a>
                    @endcan
                    @can('update sub_categories')
                        <a href="{{ route('sub_categories.edit', $sub_category->id) }}" class="btn btn-warning m-3"><i class="fa fa-edit"></i> {{ __('Edit') }}</a>
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
                            @if ($sub_category->image)
                                <div class=" text-center">
                                    <img alt="image" src="{{ $sub_category->image->getUrl('card') }}" class="border img-fluid">
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-sm-3"><b>{{ __('Name') }}:</b></div>
                                <div class="col-sm-9">{{ $sub_category->name }}</div>
                                <div class="col-sm-3"><b>{{ __('Description') }}:</b></div>
                                <div class="col-sm-9">{!! $sub_category->description !!}</div>
                                <div class="col-sm-3"><b>{{ __('Category') }}:</b></div>
                                <div class="col-sm-9">
                                    <a href="{{ route('categories.show', $sub_category->category_id) }}" class="badge badge-primary">{{ $sub_category->main_category->name }}</a>
                                </div>
                                <div class="col-sm-3"><b>{{ __('Sub sub categories') }}:</b></div>
                                <div class="col-sm-9">
                                    @if (!$sub_category->sub_sub_categories)
                                        <div class="text-warning">{{ __('Nothing yet') }}</div>
                                    @endif
                                    @foreach ($sub_category->sub_sub_categories as $sub_sub_category)
                                        <a href="{{ route('sub_sub_categories.show', $sub_sub_category->id) }}" style="margin: 10px;" class="badge badge-primary">{{ $sub_sub_category->name }}</a>
                                    @endforeach
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