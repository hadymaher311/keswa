<div class="module category-style hidden-sm hidden-xs">
    <h3 class="modtitle">{{ __('Categories') }}</h3>
    <div class="modcontent">

        <div class="box-category">
            <ul id="cat_accordion" class="list-group">
                @foreach ($all_categories as $cat)
                    <li class="hadchild"><a href="#" class="cutom-parent">{{ $cat->name }}</a>   <span class="button-view  fa fa-plus-square-o"></span>
                        <ul style="display: block;">
                            @foreach ($cat->sub_categories->where('active', '1') as $sub_cat)
                                <li class="hadchild"><a  class="cutom-parent" href="#">{{ $sub_cat->name }}</a>   <span class="button-view  fa fa-plus-square-o"></span>
                                    <ul style="display: none;">
                                        @foreach ($sub_cat->sub_sub_categories->where('active', '1') as $sub_sub_cat)
                                            <li><a href="{{ route('user.products.category.show', [$sub_sub_cat->id]) }}">{{ $sub_sub_cat->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </div>
        
    </div>
</div>