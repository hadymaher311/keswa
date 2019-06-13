@extends('admin.layouts.app')

@section('title')
{{ __('View brand') }}
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
                    <h4>{{ __('View brand') }}</h4> <br>
                        <a href="{{ route('brands.create') }}" class="btn btn-success m-3"><i class="fa fa-plus"></i> {{ __('Add new brand') }}</a>
                        <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-warning m-3"><i class="fa fa-edit"></i> {{ __('Edit') }}</a>
                    <a href="{{ route('brands.index') }}" class="btn btn-primary m-3"><i class="fa fa-home"></i> {{ __('Back to all') }}</a>
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

                    @if ($brand->image)
                        <img alt="image" src="{{ $brand->image->getUrl('thumb') }}" class="img-fluid">
                    @endif

                    <div class="row">
                        <div class="col-sm-3"><b>{{ __('Name') }}:</b></div>
                        <div class="col-sm-9">{{ $brand->name }}</div>
                        <div class="col-sm-3"><b>{{ __('Description') }}:</b></div>
                        <div class="col-sm-9">{!! $brand->description !!}</div>
                        <div class="col-sm-3"><b>{{ __('Category') }}:</b></div>
                        <div class="col-sm-9">
                            <a href="{{ route('categories.show', $brand->category_id) }}" class="badge badge-primary">{{ $brand->category->name }}</a>
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