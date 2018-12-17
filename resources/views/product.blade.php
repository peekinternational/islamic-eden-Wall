@extends('master')
@section('breadcrumb')
    @include('partials.breadcrumb')
@stop
@section('content')

    <div class="{{ isset($theme['theme']['value'])?$theme['theme']['value']:'ls' }} section_padding_top_100 section_padding_bottom_100">
        <div class="container">
            <div class="row">
                @include('partials/sidebar')
                <div class="col-sm-8">
                    <div class="shop-single">
                        <figure class="shop-single__img">
                            @if($product->images->count()>0)
                                <div class="format-gallery">
                                    <div class="entry-thumbnail">
                                        <div id="carousel-generic" class="carousel slide">
                                            <div class="carousel-inner">
                                                @foreach($product->images as $key => $image)
                                                <div class="item {{ $key==0?'active':'' }}  product-detail-img">
                                                    <img
                                                    src="{{ asset('assets/images/products/'.$image->image) }}" alt="{{ $product->name }}">
                                                </div>
                                                @endforeach
                                            </div>
                                            <a class="left carousel-control" href="#carousel-generic" data-slide="prev">
                                                <span class="format-gallery__prew"></span>
                                            </a>
                                            <a class="right carousel-control" href="#carousel-generic" data-slide="next">
                                                <span class="format-gallery__next"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <img src="{{  asset('assets/images/no-image.png') }}" alt="{{ $product->name }}">
                            @endif
                        </figure>
                        <div class="shop-single__content">
                            <ul class="shop-item__meta-list">
                                @if($product->tags->count()>0)
                                    <li>
                                        <a class="shop-item__meta-tag" href="{{ action('CategoryController@show',str_slug($product->category->name)) }}">{{ $product->category->name }}</a>
                                    </li>
                                @endif
                                <li>
                                    <h3 class="shop-item__title">
                                        {{ $product->name }}
                                    </h3>
                                </li>
                               {{-- <li>
                                    <div class="star-rating" title="Rated 4.00 out of 5">
												<span style="width:80%">
													<strong class="rating">4.00</strong> out of 5
												</span>
                                    </div>
                                </li>--}}
                            </ul>
                            <p class="shop-item__desc">
                                {{ $product->description }}
                            </p>
                            @if($product->tags->count()>0)
                                <p class="shop-tags">
                                    <span>Tags:</span>
                                    @foreach($product->tags as $key=>$tag)
                                        <a href="#">{{ $tag->name }}</a>
                                        @if(($key+1)< $product->tags->count())
                                            ,
                                        @endif
                                    @endforeach
                                </p>
                            @endif
                            <span class="price">
                                <span>
                                    @if($product->offer)
                                <span class="amount  pro-prce" style="color: gray !important; font-size: 26px;">&euro;<strike><small>{{ $product->price }}</small></strike></span>
                               <span class="amount" style="color: gray !important; font-size: 26px;">&euro;{{ $product->saleprice }}</span>
                                @else
                                    <span class="amount" style="color: black !important; font-size: 26px;">&euro;{{ $product->price }}</span>
                               @endif
                                </span>
                            </span>
                            <div class="quantity-btn">
                                {!! Form::open(['route'=>['cart.update',$product->id],'method'=>'put','class'=>'single-shop-item__gty']) !!}

                                        <span class="quantity form-group">
                                                <input type="button" value="-" class="minus">
                                                <input type="number" step="1" min="0" name="quantity" value="{{ $quantity }}" title="Qty" id="product_quantity" class="form-control ">
                                                <input type="button" value="+" class="plus">
                                        </span>
                                        <button class="button-t1" type="submit">Add to cart</button>
                                       
                                {!! Form::close() !!}
                            </div>
                            
                         {{--   <a class="btn__wish" href="#">Add to Wishlist</a>--}}
                        </div>
                    </div>
                    <div class="row" style="margin: 0px;">
                        <div role="tabpanel "  class="product_tabs">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#descript" aria-controls="home" role="tab" data-toggle="tab">DEScription</a>
                                </li>
                                <li role="presentation">
                                    <a href="#Additional-info" aria-controls="tab" role="tab" data-toggle="tab">Additional Information</a>
                                </li>
                            </ul>
                        
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="descript">{{ $product->description }}</div>
                                <div role="tabpanel" class="tab-pane" id="Additional-info">Additional</div>
                            </div>
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
                    </div>
                </div>
                <div class="col-lg-12">
                    <hr />
                    <div id="disqus_thread"></div>
                </div>
            </div>
        </div>
    </div>
   
@stop
@section('scripts')

    <script>

/**
*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
/*
var disqus_config = function () {
this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
};
*/
(function() { // DON'T EDIT BELOW THIS LINE
var d = document, s = d.createElement('script');
s.src = 'https://islamic-wall.disqus.com/embed.js';
s.setAttribute('data-timestamp', +new Date());
(d.head || d.body).appendChild(s);
})();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
@stop