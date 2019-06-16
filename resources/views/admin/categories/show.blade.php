@extends('admin.layouts.app')

@section('title')
{{ __('View category') }}
@endsection

@section('css')
    
@endsection

@section('body')
    <div class="section-header">
        <h1>{{ __('Categories') }}</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h4>{{ __('View category') }}</h4> <br>
                    @can('create categories')
                        <a href="{{ route('categories.create') }}" class="btn btn-success m-3"><i class="fa fa-plus"></i> {{ __('Add new category') }}</a>
                    @endcan

                    @can('update categories')
                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning m-3"><i class="fa fa-edit"></i> {{ __('Edit') }}</a>
                    @endcan
                    <a href="{{ route('categories.index') }}" class="btn btn-primary m-3"><i class="fa fa-home"></i> {{ __('Back to all') }}</a>
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
                            @if ($category->image)
                                <div class=" text-center">
                                    <img alt="image" src="{{ $category->image->getUrl('card') }}" class="border img-fluid">
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-sm-3"><b>{{ __('Name') }}:</b></div>
                                <div class="col-sm-9">{{ $category->name }}</div>
                                <div class="col-sm-3"><b>{{ __('Description') }}:</b></div>
                                <div class="col-sm-9">{!! $category->description !!}</div>
                                <div class="col-sm-3"><b>{{ __('Sub categories') }}:</b></div>
                                <div class="col-sm-9">
                                    @if (!$category->sub_categories)
                                        <div class="text-warning">{{ __('Nothing yet') }}</div>
                                    @endif
                                    @foreach ($category->sub_categories as $sub_category)
                                        <a href="{{ route('sub_categories.show', $sub_category->id) }}" class="badge badge-primary">{{ $sub_category->name }}</a>
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