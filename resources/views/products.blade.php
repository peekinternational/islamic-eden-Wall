@extends('master')
@section('title', 'Home Page')
@section('breadcrumb')
    @include('partials/breadcrumb')
@stop
@section('content')
    <div class="{{ isset($theme['theme']['value'])?$theme['theme']['value']:'ls' }} section_padding_top_120 section_padding_bottom_85">
        <div class="container responsive">
            <div class="row">
                 @include('partials/sidebar')
                <div class="col-sm-8 col-md-9 col-lg-9" style="margin-left: 10px;">
                    @if($products->count()>0)
                    <div class="shop-sorting hidden-xs">
                        <form class="form-inline">
                            <div class="form-group">
                                <select class="form-control orderby" name="limit" id="limit">
                                    <option value="10" selected="">10 items/pages</option>
                                    <option value="20" >20 items/pages</option>
                                    <option value="30" >30 items/pages</option>
                                    <option value="50" >50 items/pages</option>
                                </select>
                                <select class="form-control orderby" name="orderby" id="orderby_2">
                                    <option value="menu_order" selected="">Name: A to Z</option>
                                    <option value="menu_order">Name: Z to A</option>
                                    <option value="date">New First</option>
                                    <option value="date">Old First</option>
                                    <option value="price">Price: Low To High</option>
                                    <option value="price-desc">Pric: High To Low</option>
                                </select>
                            </div>
                            <div class="form-group toggle-wrapper">
                                <a href="#" id="toggle_shop_view" class=""></a>
                            </div>
                        </form>
                    </div>
                    <ul id="products" class="products list-unstyled grid-view">
                    @foreach($products as $product)

                        <li class="shop-item product type-product item-list">

                            <div class="side-item">
                                <figure class="item-media shop-item__img">
                                    <a href="{{ url('product/'.$product->slug) }}">
                                        <?php
                                            $first_image = $product->images->first();
                                            $image = 'no-image.png';
                                                if(isset($first_image->image) && !empty($first_image)){
                                                    $image = 'products/'.$first_image->image;
                                                }
                                        ?>
                                        <img src="{{  asset('assets/images/'.$image) }}" alt="{{ $product->name }}">
                                    </a>
                                </figure>
                                <div class="shop-item__content" style="padding: 0">
                                    <h3 class="shop-item__title">
                                        <a href="{{ url('/product/'.$product->slug) }}">{{ $product->name }}</a>
                                    </h3>
                                    <!-- <div class="shop-item__meta-list">
                                        
                                    </div> -->
                                    <div class="items-name" style="float: none;">
                                         @if($product->tags->count()>0)
                                         <a class="shop-item__meta-tag" href="#">{{ $product->category->name }}</a>
                                         @endif
                                        {{-- <div class="star-rating" title="Rated 4.00 out of 5">
                                                     <span style="width:80%">
                                                         <strong class="rating">4.00</strong> out of 5
                                                     </span>
                                         </div>--}}
                                     <p class="shop-item__price">
                                            <span>
                                                <span class="amount">&euro; {{ $product->price  }}</span>
                                            </span>
                                        </p>
                                    <!-- <p class="shop-item__desc">
                                       {{ $product->details }}
                                    </p> -->
                                </div>
                                <!-- <div>
                                    <span class="shop-item__price">
                                            <span>
                                                <span class="amount">&euro; {{ $product->price  }}</span>
                                            </span>
                                        </span>
                                </div> -->
                                    <div class="shop-item__block" style="text-align: center;">
                                        
                                        {!! Form::open(array('url' => 'cart','method' => 'post')) !!}
                                             {!! Form::button('Add to cart',['class'=>'button-t1','type'=>'submit']) !!}
                                             {!!  Form::hidden('id',$product->id)  !!}

                                               
                                         {!! Form::close() !!}

                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                     </ul>
                    <div class="row">
                        <div class="col-sm-12 text-left">
                            @if(isset($_GET['q']))
                                 {{ $products->appends(['q' => $_GET['q']])->links('vendor.pagination.default') }}
                            @else
                                {{ $products->links('vendor.pagination.default') }}
                            @endif
                        </div>
                    </div>
                    @else
                        <div class="alert alert-info text-center lead">
                            Products Not Found
                        </div>
                    @endif

                    
                </div>
                <div id="itemSlider">
                        <div class="col-md-12" style="display: block !important;">
                            <h2 class="text-center"> Latest Product</h2>
                            <div class="">
                                @foreach($latestProducts as $product)
                                <div class="col-md-2 category-img" style="width: 20%;">
                                    <a href="{{ url('product/'.$product->slug) }}" class="">
                                        @if($product->images->count()>0)
                                            <img src="{{ asset('assets/images/products/'.$product->images->first()->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 283px; ">
                                             
                                         @else
                                            <img class="media-object" src="{{ asset('assets/images/no-image.png') }}" alt="{{ $product->name }}">
                                        @endif
                                       
                                    </a>
                                    <div class="banner-01__content">
                                        <h5 class="card-dscrpt">
                                            <a href="{{ url('product/'.$product->slug) }}">
                                                {{ $product->name }} <br>
                                            <span>{{ $product->category['name'] }}</span></a>
                                        </h5>
                                        @if($product->offer)
                                        <p class="text-center" style="margin-bottom: 0px; color: red;">{{ $product->offer }} % off</p>
                                              <p class="text-center"> <strike style="padding: 0px 8px;"><small>€{{ $product->price }}</small> </strike>
                                              <span> €{{ $product->saleprice }}</span></p>
                                                @else
                                              <p class="text-center"> €{{ $product->price }} </p>
                                              @endif
                                            
                                    </div>
                                </div>
                                
                                @endforeach
                            </div>
                        </div>
                    </div>
         </div>
            <!-- enfd -->
    </div>
</div>

@stop


@section('scripts')
<!--=================Scroll with Menu================-->
    <script>

        $(document).ready(function(){
            // Add smooth scrolling to all links in navbar + footer link
            $(".navbar a, footer a[href='#myPage']").on('click', function(event) {
                // Make sure this.hash has a value before overriding default behavior
                if (this.hash !== "") {
                    // Prevent default anchor click behavior
                    event.preventDefault();
                    // Store hash
                    var hash = this.hash;
                    // Using jQuery's animate() method to add smooth page scroll
                    // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
                    $('html, body').animate({
                        scrollTop: $(hash).offset().top
                    }, 900, function(){
                        // Add hash (#) to URL when done scrolling (default click behavior)
                        window.location.hash = hash;
                    });
                } // End if
            });
            $(window).scroll(function() {
                $(".slideanim").each(function(){
                    var pos = $(this).offset().top;
                    var winTop = $(window).scrollTop();
                    if (pos < winTop + 600) {
                        $(this).addClass("slide");
                    }
                });
            });
        })
    </script>
    <script>
         var owl = $('.product-carousel ');
        owl.owlCarousel({
            items:10,
            loop:true,
            margin:10,
            autoplay:true,
            autoplayTimeout:1000,
            autoplayHoverPause:true
        });
        $('.play').on('click',function(){
            owl.trigger('play.owl.autoplay',[1000])
        })
        $('.stop').on('click',function(){
            owl.trigger('stop.owl.autoplay')
        })

    </script>
@stop