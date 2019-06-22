

<!-- Header Container  -->
<header id="header" class=" typeheader-1">
    
    @include('user.layouts.header.topHeader')

    <!-- Header center -->
    <div class="header-middle">
        <div class="container">
            <div class="row">
                <!-- Logo -->
                <div class="navbar-logo col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <div class="logo" style="color: white"><a class="h1" href="{{ url('/') }}">{{ config('app.name') }}</a></div>
                </div>
                <!-- //end Logo -->

                <!-- Main menu -->
                <div class="main-menu col-lg-6 col-md-7 ">
                    <div class="responsive so-megamenu megamenu-style-dev">
                        <nav class="navbar-default">
                            <div class=" container-megamenu  horizontal open ">
                                <div class="navbar-header">
                                    <button type="button" id="show-megamenu" data-toggle="collapse" class="navbar-toggle">
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                </div>
                                
                                <div class="megamenu-wrapper">
                                    <span id="remove-megamenu" class="fa fa-times"></span>
                                    <div class="megamenu-pattern">
                                        <div class="container-mega">
                                            @include('user.layouts.header.navbarCategories')
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
                <!-- //end Main menu -->

                <div class="middle-right col-lg-4 col-md-3 col-sm-6 col-xs-8">                  
                    <div class="signin-w  hidden-sm hidden-xs">
                        <ul class="signin-link blank">                            
                            <li class="log login"><i class="fa fa-lock"></i> <a class="link-lg" href="{{ route('login') }}">{{ __('Login') }} </a> or <a href="{{ route('register') }}">{{ __('Register') }}</a></li>                                
                        </ul>                       
                    </div>
                    <div class="telephone hidden-xs hidden-sm hidden-md">
                        <ul class="blank"> <li><a href="#"><i class="fa fa-truck"></i>{{ __('Track your order') }}</a></li> <li><a href="#"><i class="fa fa-phone-square"></i>{{ __('Contact US') }}</a></li> </ul>
                    </div>
                                        
                    
                </div>
                
            </div>

        </div>
    </div>
    <!-- //Header center -->

    <!-- Header Bottom -->
    <div class="header-bottom hidden-compact">
        <div class="container">
            <div class="row">
                
                <div class="bottom1 menu-vertical col-lg-2 col-md-3 col-sm-3">
                    <div class="responsive so-megamenu megamenu-style-dev ">
                        <div class="so-vertical-menu ">
                            @include('user.layouts.header.sidenavbarAllCategories')
                        </div>
                    </div>

                </div>
                
                <!-- Search -->
                <div class="bottom2 col-lg-7 col-md-6 col-sm-6">
                    <div class="search-header-w">
                        <div class="icon-search hidden-lg hidden-md hidden-sm"><i class="fa fa-search"></i></div>                                
                            
                        <div id="sosearchpro" class="sosearchpro-wrapper so-search ">
                            <form method="GET" action="index.html">
                                <div id="search0" class="search input-group form-group">
                                    <div class="select_category filter_type  icon-select hidden-sm hidden-xs">
                                        <select class="no-border" name="category_id">
                                            <option value="0">{{ __('All Categories') }}</option>
                                            @foreach ($all_sub_sub_categories as $sub_sub_category)
                                                <option value="{{ $sub_sub_category->id }}">{{ $sub_sub_category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <input class="autosearch-input form-control" type="text" value="" size="50" autocomplete="off" placeholder="{{ __('Search') }} ..." name="search">
                                    <span class="input-group-btn">
                                    <button type="submit" class="button-search btn btn-primary" name="submit_search"><i class="fa fa-search"></i></button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>  
                </div>
                <!-- //end Search -->
                
                <!-- Secondary menu -->
                <div class="bottom3 col-lg-3 col-md-3 col-sm-3">
                    

                    <!--cart-->
                    <div class="shopping_cart">
                        <div id="cart" class="btn-shopping-cart">

                            <a data-loading-text="Loading... " class="btn-group top_cart dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                <div class="shopcart">
                                    <span class="icon-c">
                            <i class="fa fa-shopping-bag"></i>
                            </span>
                                    <div class="shopcart-inner">
                                        <p class="text-shopping-cart">

                                            {{ __('My cart') }}
                                        </p>

                                        <span class="total-shopping-cart cart-total-full">
                                            <span class="items_cart">02</span><span class="items_cart2"> {{ __('Item') }}</span><span class="items_carts"> - $162.00 </span>
                                        </span>
                                    </div>
                                </div>
                            </a>

                            <ul class="dropdown-menu pull-right shoppingcart-box" role="menu">
                                <li>
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <td class="text-center" style="width:70px">
                                                    <a href="product.html">
                                                        <img src="image/catalog/demo/product/80/1.jpg" style="width:70px" alt="Yutculpa ullamcon" title="Yutculpa ullamco" class="preview">
                                                    </a>
                                                </td>
                                                <td class="text-left"> <a class="cart_product_name" href="product.html">Yutculpa ullamco</a> 
                                                </td>
                                                <td class="text-center">x1</td>
                                                <td class="text-center">$80.00</td>
                                                <td class="text-right">
                                                    <a href="product.html" class="fa fa-edit"></a>
                                                </td>
                                                <td class="text-right">
                                                    <a onclick="cart.remove('2');" class="fa fa-times fa-delete"></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </li>
                                <li>
                                    <div>
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td class="text-left"><strong>Sub-Total</strong>
                                                    </td>
                                                    <td class="text-right">$140.00</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left"><strong>Eco Tax (-2.00)</strong>
                                                    </td>
                                                    <td class="text-right">$2.00</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left"><strong>VAT (20%)</strong>
                                                    </td>
                                                    <td class="text-right">$20.00</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left"><strong>Total</strong>
                                                    </td>
                                                    <td class="text-right">$162.00</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <p class="text-right"> <a class="btn view-cart" href="cart.html"><i class="fa fa-shopping-cart"></i>View Cart</a>&nbsp;&nbsp;&nbsp; <a class="btn btn-mega checkout-cart" href="checkout.html"><i class="fa fa-share"></i>Checkout</a> 
                                        </p>
                                    </div>
                                </li>
                            </ul>
                        </div>

                    </div>
                    <!--//cart-->

                    <ul class="wishlist-comp hidden-md hidden-sm hidden-xs">
                        <li class="wishlist hidden-xs"><a href="#" id="wishlist-total" class="top-link-wishlist" title="Wish List (0) "><i class="fa fa-heart"></i></a>
                        </li>
                    </ul>
                </div>
                
            </div>
        </div>

    </div>
</header>
<!-- //Header Container  -->