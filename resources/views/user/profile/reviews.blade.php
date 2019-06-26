@extends('user.layouts.app')

@section('title')
    {{ auth()->user()->name }} - {{ __('Reviews') }} - {{ config('app.name') }}
@endsection

@section('css')
@endsection

@section('body')
<!-- Main Container  -->
<div class="main-container container" style="margin-top: 4rem">

    <div class="row">
        <!--Middle Part Start-->
        <div id="content" class="col-sm-9">
            <h2 class="title">{{ __('My Reviews') }}</h2>
            <h3>{{ __('Hi') }}, <b>{{ auth()->user()->name }}</b></h3>
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">{{ __('Pending Reviews') }}</div>
                        <div class="panel-body">
                            <table class="table table-striped table-bordered">
                                <tbody>
                                    @foreach ($pending_reviews as $review) 
                                        <tr>
                                            <td style="width: 50%;">
                                                <strong><a href="{{ route('user.products.show', ['product'=> $review->product->id, 'slug' => $review->product->slug]) }}">{{ $review->product->name }}</a></strong>
                                            </td>
                                            <td class="text-right">
                                                <a 
                                                    href="#" 
                                                    class="btn btn-danger btn-xs"
                                                    onclick="
                                                            event.preventDefault();
                                                            if(confirm('{{ __('Are you sure you want to delete this row?') }}')) {
                                                                $(this).siblings('form').submit();
                                                            }" data-toggle="tooltip" data-placement="top" title="{{ __('Delete') }}"
                                                ><i class="fa fa-times"></i> {{ __('Delete') }}</a> &nbsp;&nbsp;&nbsp;
                                                <form style="display: none" action="{{ route('user.reviews.destroy', $review->id) }}" method="POST">
                                                    @csrf
                                                    {{ method_field('DELETE') }}
                                                </form>
                                                <a href="{{ route('user.reviews.edit', $review->id) }}"  data-toggle="tooltip" data-placement="top" title="{{ __('Edit') }}" class=""><i class="fa fa-edit"></i> {{ __('Edit') }}</a>&nbsp;&nbsp;&nbsp;
                                                {{ $review->created_at->format('Y/m/d') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <p>{!! $review->content !!}</p>
                                                <div class="ratings">
                                                    <div class="rating-box">
                                                        @php $rating = $review->rate; @endphp  

                                                        @include('user.components.rating')
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>                   
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $pending_reviews->links() }}
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">{{ __('Approved Reviews') }}</div>
                        <div class="panel-body">
                            <table class="table table-striped table-bordered">
                                <tbody>
                                    @foreach ($approved_reviews as $review) 
                                        <tr>
                                            <td style="width: 50%;">
                                                <strong><a href="{{ route('user.products.show', ['product'=> $review->product->id, 'slug' => $review->product->slug]) }}">{{ $review->product->name }}</a></strong>
                                            </td>
                                            <td class="text-right">
                                                <a 
                                                    href="#" 
                                                    class="btn btn-danger btn-xs"
                                                    onclick="
                                                            event.preventDefault();
                                                            if(confirm('{{ __('Are you sure you want to delete this row?') }}')) {
                                                                $(this).siblings('form').submit();
                                                            }" data-toggle="tooltip" data-placement="top" title="{{ __('Delete') }}"
                                                ><i class="fa fa-times"></i> {{ __('Delete') }}</a> &nbsp;&nbsp;&nbsp;
                                                <form style="display: none" action="{{ route('user.reviews.destroy', $review->id) }}" method="POST">
                                                    @csrf
                                                    {{ method_field('DELETE') }}
                                                </form>
                                                <a href="{{ route('user.reviews.edit', $review->id) }}"  data-toggle="tooltip" data-placement="top" title="{{ __('Edit') }}" class=""><i class="fa fa-edit"></i> {{ __('Edit') }}</a>&nbsp;&nbsp;&nbsp;
                                                {{ $review->created_at->format('Y/m/d') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <p>{!! $review->content !!}</p>
                                                <div class="ratings">
                                                    <div class="rating-box">
                                                        @php $rating = $review->rate; @endphp  

                                                        @include('user.components.rating')
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>                   
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $approved_reviews->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('user.components.accountSideLinks')

    </div>
</div>
<!-- //Main Container -->
@endsection

@section('js')

@endsection
