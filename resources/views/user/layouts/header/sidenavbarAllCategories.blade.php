<nav class="navbar-default">    
                            
    <div class="container-megamenu vertical">
        <div id="menuHeading">
            <div class="megamenuToogle-wrapper">
                <div class="megamenuToogle-pattern">
                    <div class="container">
                        <div>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        {{ __('All Categories') }}                          
                    </div>
                </div>
            </div>
        </div>
        
        <div class="navbar-header">
            <button type="button" id="show-verticalmenu" data-toggle="collapse" class="navbar-toggle">      
                <i class="fa fa-bars"></i>
                <span>  {{ __('All Categories') }}     </span>
            </button>
        </div>
        <div class="vertical-wrapper" >
            <span id="remove-verticalmenu" class="fa fa-times"></span>
            <div class="megamenu-pattern">
                <div class="container-mega">
                    <ul class="megamenu">
                        @foreach ($all_categories as $category)
                            <li class="item-vertical  with-sub-menu hover">
                                <p class="close-menu"></p>
                                <a href="#" class="clearfix">
                                    <span>{{ $category->name }}</span>
                                    <b class="caret"></b>
                                </a>
                                <div class="sub-menu" data-subwidth="60"  >
                                    <div class="content" >
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <div class="col-md-4 static-menu">
                                                        <div class="menu">
                                                            <ul>
                                                                @foreach ($category->sub_categories->where('active', '1') as $sub_category)
                                                                    <li>
                                                                        <a href="#"  class="main-menu">{{ $sub_category->name }}</a>
                                                                        <ul>
                                                                            @foreach ($sub_category->sub_sub_categories->where('active', '1') as $sub_sub_category) 
                                                                                <li><a href="{{ route('user.products.category.show', [$sub_sub_category->id]) }}" >{{ $sub_sub_category->name }}</a></li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                            
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>