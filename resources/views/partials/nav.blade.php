<header class="{{ isset($theme['theme']['value'])?$theme['theme']['value']:'ls' }}">
    <div class="page_header header-01 mbl-view-header" style="height: 70px; background-color: white;">
        <div class="container">
            <div class="row respnsve" style="background-color: white; height: 20px;">
                <div class=" col-md-2 col-sm-12 text-md-center hidden-xs hidden-sm">
                    <a href="{{ url('/') }}" class="logo">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="">
                    </a>
                </div>
             <div class=" col-md-8 col-sm-2 text-lg-center">
                <span class="toggle_menu">
                <span></span>
                </span>
                    <div class="navbar hidden-xs hidden-sm" >
                        @foreach($navs as $key=>$nav)
                        @if(!$nav->hidden)
                            
                            <?php
                            $url = '#';
                            if(trim($nav->slug) == 'about'){
                                $url = url('/').'#about-us';
                            }elseif($nav->slug == 'home'){
                                $url = url('/');
                            }elseif($nav->slug == 'blog'){
                                $url = url('/blog');
                            }elseif($nav->slug =='shop'){
                                $url = url('/').'#shop';
                            }
                            elseif($nav->slug =='decore'){
                                $url = url('/').'#decore';
                            }
                            elseif($nav->slug =='home-goods'){
                                $url = url('/').'#home-goods';
                            }elseif($nav->page_id>0 && isset($nav->page->slug) && !empty($nav->page->slug)){
                                $url = url($nav->page->slug.'/page');
                            }
                            if(!empty($nav->url) && filter_var($nav->url,FILTER_VALIDATE_URL) == true){
                                $url = $nav->url;
                            }
                        ?>
            
                    <div class="subnav">
                        <a href="{{ $url }}" class="subnavbtn">{{ $nav->title }} </a>
                        @if($nav->title=='HOME')
                        @elseif($nav->title=='About')
                        @elseif($nav->title=='contact')
                        @elseif($nav->title=='home goods')
                         @elseif($nav->title=='BLOG')
                        @else

                        
                            <div class="row sub-menu">
                                <div class="subnav-content sub-align  affix-top">
                                @foreach($nav->sub_navs as $sub_nav)
                                
                                <div class="col-md-2 col-lg-2 sub-men">
                            @if($nav->slug == 'shop')
                            <a class="sub-men" href="{{ url('shop/'.$sub_nav->slug) }}" ><b>{{ $sub_nav->title }}</b></a>
                            
                            <div class="sub-men">
                                @foreach($sub_nav->more_subnav as $msub_nav)
                                
                                <div class="col-md-7 col-lg-7">
                                    
                                    <a href="{{ $msub_nav->url }}" style="color: #989898;">{{ $msub_nav->title }}</a>
                                                        
                                </div>
                                @endforeach
                            </div>
                        @elseif($nav->slug == 'decore')
                            <a href="{{ url('shop/'.$sub_nav->slug) }}">{{ $sub_nav->title }}</a>
                                      <div class="">
                                @foreach($sub_nav->more_subnav as $msub_nav)
                                
                                <div class="col-md-12 col-lg-12">
                                    
                                    <a href="{{ $msub_nav->url }}" style="color: #989898;">{{ $msub_nav->title }}</a>
                                                        
                                </div>
                                @endforeach
                            </div>
                            @elseif($nav->slug == 'home-goods')
                            <a href="{{ url('shop/'.$sub_nav->slug) }}">{{ $sub_nav->title }}</a>
                                      <div class="">
                                @foreach($sub_nav->more_subnav as $msub_nav)
                                
                                <div class="col-md-12 col-lg-12">
                                    
                                    <a href="{{ url('shop/'.$sub_nav->slug) }}" style="color: #989898;">{{ $msub_nav->title }}</a>
                                                        
                                </div>
                                @endforeach
                            </div>
                        @elseif($nav->slug =='useful')
                                <?php $url = url($sub_nav->page->slug.'/page'); ?>
                                <a href="{{ $url }}">{{ $sub_nav->title }}</a>
                        @else
                            
                        @endif
                    </div>
                        @endforeach
                            </div>
                            </div>
                            @endif
                        </div>
                        @endif
                        @endforeach
                        </div>
                    

                    <!-- main nav start -->
                    <nav class="mainmenu_wrapper hidden-md hidden-lg" >
                        <ul class="mainmenu nav sf-menu ">
                            @foreach($navs as $key=>$nav)
                                @if(!$nav->hidden)
                                    <li class="a-shop {{ $key==0?'active':'' }}">
                                         <?php
                                            $url = '#';
                                            if(trim($nav->slug) == 'about'){
                                                $url = url('/').'#about-us';
                                            }elseif($nav->slug == 'home'){
                                                $url = url('/');
                                            }elseif($nav->slug == 'blog'){
                                                $url = url('/blog');
                                            }elseif($nav->slug =='shop'){
                                                $url = url('/').'#shop';
                                            }
											elseif($nav->slug =='decore'){
                                                $url = url('/').'#decore';
                                            }
											elseif($nav->slug =='home-goods'){
                                                $url = url('/').'#home-goods';
                                            }elseif($nav->page_id>0 && isset($nav->page->slug) && !empty($nav->page->slug)){
                                                $url = url($nav->page->slug.'/page');
                                            }
                                            if(!empty($nav->url) && filter_var($nav->url,FILTER_VALIDATE_URL) == true){
                                                $url = $nav->url;
                                            }
                                        ?>
                                        <a href="{{ $url }}" class="" style="color: {{ $nav->color }};padding: 25px 10px;font-size: 18px;"  onmouseout="this.style.color='{{ $nav->color }}'" onmouseover="this.style.color = 'inherit'">{{ $nav->title }}</a>
                                        @if($nav->sub_navs->count()>0)
                                        <ul style="display: none !important;" id="sub_ul">
                                            @foreach($nav->sub_navs as $sub_nav)
                                               
                                                    <li>
                                                        @if($nav->slug == 'shop')
                                                            <a href="{{ url('shop/'.$sub_nav->slug) }}">{{ $sub_nav->title }}</a>
														@elseif($nav->slug == 'decore')
                                                            <a href="{{ url('shop/'.$sub_nav->slug) }}">{{ $sub_nav->title }}</a>
															@elseif($nav->slug == 'home-goods')
                                                            <a href="{{ url('shop/'.$sub_nav->slug) }}">{{ $sub_nav->title }}</a>
                                                        @elseif($nav->slug =='useful')
                                                             <?php $url = url($sub_nav->page->slug.'/page'); ?>
                                                              <a href="{{ $url }}">{{ $sub_nav->title }}</a>
                                                        @else
                                                           
                                                        @endif

                                                         @if($sub_nav->more_subnav->count()>0)
                                                            <ul class="more_sub">
                                                                @foreach($sub_nav->more_subnav as $sub_nav)
                                                                    @if(!$sub_nav->hidden)
                                                                        <li>
                                                                           
                                                                                <a href="{{ url('shop/'.$sub_nav->slug) }}">{{ $sub_nav->title }}</a>
                                                                           
                                                                        </li>
                                                                    @endif
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                
                                            @endforeach
                                        </ul>
                                        @endif
                                    </li>
                                @endif
                            @endforeach
                          {{--  <li class="active flex-col hide-for-medium flex-center">
                                <a href="{{ url('/') }}" class="sf-with-ul">HOME</a>
                            </li>
                            <li class="a-shop">
                                <a href="#shop" class="sf-with-ul">ART</a>
                                <ul style="display: none;">
                                    @foreach($shop_categories as $category)
                                        <li>
                                            <a href="{{ url('category/'.$category->slug) }}">{{ $category->title }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            <!-- pages -->
                            <li class="a-eat" >
                                <a href="#" onmouseout="this.style.color='inherit'" onmouseover="this.style.color = 'red'"  class="sf-with-ul">DECOR</a>
                                <ul style="display: none;">
                                    <li>
                                        <a href="#">Cafe</a>
                                    </li>
                                    <li>
                                        <a href="#">Functions</a>
                                    </li>
                                    <li>
                                        <a href="#">Catering</a>
                                    </li>
                                    <li>
                                        <a href="#">Recipes</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="a-play">
                                <a href="#play" class="sf-with-ul">HOME GOODS</a>
                                <ul style="display: none;">
                                    <li>
                                        <a href="#">Soft Play</a>
                                    </li>
                                    <li>
                                        <a href="#">Birthday Parties</a>
                                    </li>
                                    <li>
                                        <a href="#">Outdoor Animals</a>
                                    </li>
                                    <li>
                                        <a href="#">Outdoor Play</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="a-rest">
                                <a href="#" class="sf-with-ul">FAQS</a>
                                <ul style="display: none;">
                                    <li>
                                        <a href="#">Bunkhouse</a>
                                    </li>
                                    <li>
                                        <a href="#">Wigwams</a>
                                    </li>
                                    <li>
                                        <a href="#">Video button</a>
                                    </li>
                                    <li>
                                        <a href="#">Location</a>
                                    </li>
                                    <li>
                                        <a href="#">Awards</a>
                                    </li>
                                    <li>
                                        <a href="#">Newsletter Sign up</a>
                                    </li>
                                    <li>
                                        <a href="#">Offers/Special Events</a>
                                    </li>
                                </ul>
                            </li>
                            
                             
                           
                            <li class="">
                                <a href="{{ url('/contact-us') }}" class="sf-with-ul">Contact </a>
                            </li>--}}
                    </nav>
                    <!-- eof main nav -->
                </div>
                <div class="  col-xs-4 hidden-md hidden-lg hidden-sm">
                    <a href="{{ url('/') }}" class="logo">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="">
                    </a>
                </div>
                <div class=" col-lg-offset-6 col col-lg-3 mbl-cart-sec text-right hidden-lg hidden-md hidden-sm ">
                <div class="shopping-cart">

                    <a class="shopping-cart__content header-button" id="cart" data-target="#"
                       href="{{ route('cart.index') }}" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false">
                        <span class="shopping-cart__info" style="font-size: 12px !important;">
                           
                            @if($cart_items>0)
                                {{ $cart_items }} Items  &euro;{{ $cart->subTotal($format = false, $withDiscount = true) }}
                            @else
                                My Cart (0):$0
                            @endif
                           </span>
                           <button class="btn checkout-btn">Checkout</button>

                    </a>
                    @if($cart_items > 0)
                    <div class="shopping-cart__list dropdown-menu" aria-labelledby="cart">
                       {{-- <span class="grey">Recently added item(s)</span>--}}
                        <div class="shopping-cart">
                           {{-- <a class="shopping-cart__content header-button" id="cart" data-target="#"
                               href="http://webdesign-finder.com/" data-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false">
                                <span class="shopping-cart__info">3 Items</span>
                                $ 25.99
                            </a>
                            <div class="shopping-cart__list dropdown-menu" aria-labelledby="cart">
                --}}

                                <span class="grey">Recently added item(s)</span>
                                <div class="widget widget_shopping_cart">
                                    <div class="widget_shopping_cart_content">
                                        <ul class="cart_list product_list_widget media-list darklinks">
                                             <?php 
                                                   print_r($cart->subTotal($format = false, $withDiscount = true));
                                                ?>
                                            @foreach($cart->getItems() as $item)
                                             <li class="media">
                                                <div class="media-left media-middle">
                                                    <a href="{{ route('product.show',['slug'=>$item->slug]) }}">
                                                        <img src="{{  asset($item->options['image']) }}" alt="{{ $item->name }}">
                                                    </a>
                                                </div>
                                                <div class="media-body media-middle">
                                                    <h4>
                                                        <a href="blog-right.html">{{ $item->options['name'] }}</a>
                                                    </h4>
                                                      <span class="quantity">{{ $item->options['qty'] }} ×
                                                       <span class="amount">&euro; {{ $item->options['price'] }}</span>
                                                      </span>
                                                </div>
                                                <div class="media-body media-middle">
                                                    {!! Form::open(array('route' => array('cart.destroy', $item->options['id']),'method' => 'delete')) !!}
                                                        <button type="submit" class="remove" style="background: transparent; border: none;" title="Remove this item">
                                                            <i class="rt-icon2-trash highlight"></i>
                                                        </button>
                                                    {!! Form::close() !!}
                                                    {{--<a href="#" class="remove" title="Remove this item">
                                                        <i class="rt-icon2-trash highlight"></i>
                                                    </a>--}}
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                        <!-- end product list -->
                                        <p class="total">
                                            <span class="grey">Cart Subtotal:

                                            <span class="amount">${{ $cart->subTotal($format = false, $withDiscount = true) }}</span>
                                            </span>
                                        </p>
                                        <p class="buttons">
                                            <a href="{{ route('cart.index') }}" class="button-t1">View All</a>
                                            <a href="{{ route('cart.checkout') }}" class="button-t1">Checkout</a>
                                        </p>
                                    </div>
                                </div>

                            </div>
                     {{--   </div>--}}
                    </div>
                    @endif
                </div>
            </div>
                <div class="col-md-2 col-sm-7 text-righ hidden-xs hidden-sm" style="padding-top: 4px; position: relative;">
                        <!-- {!! Form::open(['route' => 'search','class'=>'searchform search-form','method'=>'get']) !!}
                        <input type="text" value="{{ ((isset($_GET['q']) && !empty($_GET['q'])?$_GET['q']:'')) }}" name="q" class="search-form__search form-control"
                               placeholder="Search keyword" id="modal-search-input">
                        <button type="submit" class="search-form__button">Search</button>
                        {!! Form::close() !!}

                        <div class="modal" tabindex="-1" role="dialog" aria-labelledby="search_modal"
                             id="search_modal"></div> -->

                            
                        <div class="inner-addon right-addon header-search-bar">
                        
                            {!! Form::open(['route' => 'search','class'=>'searchform search-form','method'=>'get']) !!}
                            <button type="submit" class="search-form__button"><i class="fa fa-search"></i></button>
                            <input type="text" class="form-control" name="q" value="{{ ((isset($_GET['q']) && !empty($_GET['q'])?$_GET['q']:'')) }}" placeholder="Search keyword"  id="modal-search-input">
                            {!! Form::close() !!}
                        </div>
                        <div class="modal" tabindex="-1" role="dialog" aria-labelledby="search_modal"
                           id="search_modal"></div>
                    </div>
              
            </div>
        </div>
        <!-- on mobile view search -->
        <div class="col-xs-12 hidden-lg hidden-md " style="padding-top: 0px; position: relative;">
          <div class="inner-addon right-addon header-search-bar">
          
              {!! Form::open(['route' => 'search','class'=>'searchform search-form','method'=>'get']) !!}
              <button type="submit" class="search-form__button"><i class="fa fa-search"></i></button>
              <input type="text" class="form-control" name="q" value="{{ ((isset($_GET['q']) && !empty($_GET['q'])?$_GET['q']:'')) }}" placeholder="Search keyword"  id="modal-search-input">
              {!! Form::close() !!}
          </div>
        </div>
    </div>
</header>
