<ul class="megamenu" data-transition="slide" data-animationtime="250">
    @foreach ($visible_categories as $category)    
        <li class="with-sub-menu hover">
            <p class="close-menu"></p>
            <a href="#" class="clearfix">
                <strong>{{ $category->name }}</strong>
                <b class="caret"></b>
            </a>
            <div class="sub-menu" style="width: 100%; right: auto;">
                <div class="content" >
                    <div class="row">
                        @foreach ($category->sub_categories->where('navbar_visibility', '1')->where('active', '1') as $sub_category)
                            <div class="col-md-3">
                                <div class="column">
                                    <a href="#" class="title-submenu">{{ $sub_category->name }}</a>
                                    <div>
                                        <ul class="row-list">
                                            @foreach ($sub_category->sub_sub_categories->where('navbar_visibility', '1')->where('active', '1') as $sub_sub_category)
                                                <li><a href="#">{{ $sub_sub_category->name }}</a></li>
                                            @endforeach
                                        </ul>
                                        
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </li>
    @endforeach
    
    <li class="">
        <p class="close-menu"></p>
        <a href="#" class="clearfix">
            <strong>{{ __('About') }}</strong>

        </a>

    </li>
    
    
</ul>