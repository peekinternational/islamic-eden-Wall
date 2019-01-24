
<div class="top_header_bg hidden-xs">
    <div id="home" class="{{ isset($theme['theme']['value'])?$theme['theme']['value']:'ls' }} page_toplogo">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-sm-4">
                <ul class="social-list">
                        @if(isset($site['facebook']['value']) && (!isset($site['hide_facebook']['value']) || $site['hide_facebook']['value']!='1'))
                            <li>
                                <a href="{{ $site['facebook']['value'] }}">
                                    <i class="fa fa-facebook-f"></i>
                                </a>
                            </li>
                        @endif
                        @if(isset($site['twitter']['value']) && (!isset($site['hide_twitter']['value']) || $site['hide_twitter']['value']!='1'))
                            <li>
                                <a href="{{ $site['twitter']['value'] }}">
                                    <i class="fa fa-twitter"></i>
                                </a>
                            </li>
                        @endif
                        @if(isset($site['google_plus']['value']) && (!isset($site['hide_google_plus']['value']) || $site['hide_google_plus']['value']!='1'))
                            <li>
                                <a href="{{ $site['google_plus']['value'] }}">
                                    <i class="fa fa-google-plus"></i>
                                </a>
                            </li>
                        @endif
                        @if(isset($site['linkedin']['value']) && (!isset($site['hide_linkedin']['value']) || $site['hide_linkedin']['value']!='1'))
                            <li>
                                <a href="{{ $site['linkedin']['value'] }}">
                                    <i class="fa fa-linkedin"></i>
                                </a>
                            </li>
                        @endif
                        @if(isset($site['flickr']['value']) && (!isset($site['hide_flickr']['value']) || $site['hide_flickr']['value']!='1'))
                            <li>
                                <a href="{{ $site['flickr']['value'] }}">
                                    <i class="fa fa-flickr"></i>
                                </a>
                            </li>
                        @endif
                        @if(isset($site['instagram']['value']) && (!isset($site['hide_instagram']['value']) || $site['hide_instagram']['value']!='1'))
                            <li>
                                <a href="{{ $site['instagram']['value'] }}">
                                    <i class="fa fa-instagram"></i>
                                </a>
                            </li>
                        @endif
                        @if(isset($site['youtube']['value']) && (!isset($site['hide_youtube']['value']) || $site['hide_youtube']['value']!='1'))
                            <li>
                                <a href="{{ $site['youtube']['value'] }}">
                                    <i class="fa fa-youtube"></i>
                                </a>
                            </li>
                        @endif
                        @if(isset($site['skype']['value']) && (!isset($site['hide_skype']['value']) || $site['hide_skype']['value']!='1'))
                            <li>
                                <a href="skype:{{$site['skype']['value']}}">
                                    <i class="fa fa-skype"></i>
                                </a>
                            </li>
                        @endif
                        @if(isset($site['tripadvisor']['value']) && (!isset($site['hide_tripadvisor']['value']) || $site['hide_tripadvisor']['value']!='1'))
                            
                        @endif
                </ul>
            </div>
            <div class=" col-lg-offset-6 col col-lg-3 text-right">
                <div class="shopping-cart">

                    <a class="shopping-cart__content header-button" id="cart" data-target="#"
                       href="{{ route('cart.index') }}" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false">
                        <span class="shopping-cart__info" style="font-size: 13px !important;">
						<?php 
						  $i =0;
						?>
                        @foreach($cart->getItems() as $item)
                       
                        <?php $total=$item->qty+$i;
                             $i++;
						?>
						@endforeach
						
                       
                            @if($cart_items>0)

                                {{ $total }} CART  &euro;{{ $cart->subTotal($format = false, $withDiscount = true) }}

                            @else
                                My Cart (0):$0
                            @endif
                           </span>
                           <a href="{{asset('/checkout')}}" class="btn checkout-btn">Checkout</a>

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
                                             
                                            @foreach($cart->getItems() as $item)
                                             <li class="media">
                                                <div class="media-left media-middle" style="vertical-align:top;">
                                                    <a href="{{ url('product/'.$item->slug)}}">
                                                        <img src="{{  asset($item->options['image']) }}" alt="{{ $item->name }}">
                                                    </a>
                                                </div>
                                                <div class="media-body media-middle">
                                                    <h4>
                                                        <a href="{{ url('product/'.$item->slug)}}">{{ $item->options['name'] }}</a>
                                                    </h4>
                                                      <p class="quantity" style="margin-bottom:0px;">{{ $item->options['qty'] }} ×
                                                       <span class="amount">&euro; {{ $item->options['price'] }}</span>
                                                      </p>
                                                      <p class="">{{ $item->options['color'] }}  
                                                          @if($item->options['p_size'])
                                                           <span class="" style="color: black;">({{ strtoupper($item->options['p_size'] )}})</span>
                                                        @else
                                                           <span class="" style="color: black;">({{ strtoupper($item->options['p_dimension'] )}})</span>
                                                       @endif
                                                      </p>
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
           
                <!-- <div class="  col-lg-4" style="padding: 16px 23px;">
                    <i class="fa fa-phone" aria-hidden="true" style="color: white;"></i>
                  <h4 style="color: white;" class="icon"><i   class="fa fa-phone" aria-hidden="true" ></i> 01360771 707</h4>

                </div> -->
        </div>
            
            <!-- Search div -->         
            <!-- <div class="col-lg-4 col-md-3 col-sm-4 text-sm-center text-right" style="padding-top: 4px;">
                {!! Form::open(['route' => 'search','class'=>'searchform search-form','method'=>'get']) !!}
                <input type="text" value="{{ ((isset($_GET['q']) && !empty($_GET['q'])?$_GET['q']:'')) }}" name="q" class="search-form__search form-control"
                       placeholder="Search keyword" id="modal-search-input">
                <button type="submit" class="search-form__button">Search</button>
                {!! Form::close() !!}

                <div class="modal" tabindex="-1" role="dialog" aria-labelledby="search_modal"
                     id="search_modal"></div>
            </div> -->
               <!--  End of search Div -->
            
            
        </div>
    </div>
</div>
 
