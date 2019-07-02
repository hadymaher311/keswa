@extends('admin.layouts.app')

@section('title')
    {{ __('General Settings') }}
@endsection

@section('css')
    
@endsection

@section('body')

<div class="section-header">
    <h1>{{ __('General Settings') }}</h1>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
                <div class="card">
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
                    <form action="{{ route('admin.general.settings.price.tax') }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-3 mt-3 col-form-label">{{ __('Price Tax') }} ({{ __('Percentage') }})</label>
                            <div class="col-sm-6 mt-3">
                                <input id="price_tax" type="number" min="0" class="form-control @error('price_tax') is-invalid @enderror" name="price_tax" value="{{ ($price_tax) ? $price_tax->value : 0 }}" autocomplete="price_tax" autofocus>
                                
                                @error('price_tax')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-sm-3 mt-3">
                                <button type="submit" class="btn btn-warning btn-block">{{ __('Submit') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    
@endsection