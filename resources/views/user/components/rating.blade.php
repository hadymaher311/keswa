@foreach(range(1,5) as $i)
    <span class="fa-stack">
        <i class="fa fa-star-o fa-stack-2x"></i>

        @if($rating >0)
            @if($rating >0.5)
                <i class="fa fa-star fa-stack-2x"></i>
            @else
                <i style="color: #ff9600;" class="fa fa-star-half-o fa-stack-2x"></i>
            @endif
        @endif
        @php $rating--; @endphp
    </span>
@endforeach