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
                         @if($product_color->count()>0)
                                <p class="shop-tags">
                                    <div style="display: -webkit-box;">
                                    <span>Color:</span>
                                    @foreach($product_color as $key=>$color)
                                    <input id="checkboxid{{$color->id}}" onclick="colorselect({{$color->id}})" name="color" type="checkbox" value="{{$color->color}}" class="css-checkbox onlyone">
                                     <label for="checkboxid{{$color->id}}" class="css-label">{{ucfirst($color->color)}}</label>
                                        @if(($key+1)< $product_color->count())
                                                	&nbsp;&nbsp;
                                       @endif
                                    @endforeach
                                    </div>
                                </p>
                            @endif
                            @if($product_size->count()>0)
                                 <p class="shop-tags">
                                     <div style="display: -webkit-box;">
                                    <span>Size:</span>
                                    @foreach($product_size as $key=>$size)
                                    <input id="checkboxidd{{$size->id}}" onclick="sizeselect({{$size->id}})" type="radio" name="p_size" value="{{$size->p_size}}" class="css-checkbox onlyone">
                                       <label for="checkboxidd{{$size->id}}" class="css-label">{{strtoupper( $size->p_size)}}</label>
                                       
                                        @if(($key+1)< $product_size->count())
                                                   	&nbsp;&nbsp;
                                        @endif
                                    @endforeach
                                    </div>
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
                                                <input type="hidden" name="color" id="sel_color">
                                                <input type="hidden" name="p_size" id="sel_size">
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
                       
                    </div>
                </div>
                
                <div class="col-lg-12">
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
            </div>
        </div>
    </div>
   
@stop
@section('scripts')

    <script>
        function colorselect(id)
        {
           var data= $('#checkboxid'+id).val();
           $('#sel_color').val(data);
        //   / alert(data);
        }
        function sizeselect(id)
        {
           var datas= $('#checkboxidd'+id).val();
           $('#sel_size').val(datas);
        //   / alert(data);
        }
$("input:checkbox").on('click', function() {
  // in the handler, 'this' refers to the box clicked on
  var $box = $(this);
  if ($box.is(":checked")) {
    // the name of the box is retrieved using the .attr() method
    // as it is assumed and expected to be immutable
    var group = "input:checkbox[name='" + $box.attr("name") + "']";
    // the checked state of the group/box on the other hand will change
    // and the current value is retrieved using .prop() method
    $(group).prop("checked", false);
    $box.prop("checked", true);
  } else {
    $box.prop("checked", false);
  }
});

$("input:radio").on('click', function() {
  // in the handler, 'this' refers to the box clicked on
  var $box = $(this);
  if ($box.is(":checked")) {
    // the name of the box is retrieved using the .attr() method
    // as it is assumed and expected to be immutable
    var group = "input:radio[name='" + $box.attr("name") + "']";
    // the checked state of the group/box on the other hand will change
    // and the current value is retrieved using .prop() method
    $(group).prop("checked", false);
    $box.prop("checked", true);
  } else {
    $box.prop("checked", false);
  }
});
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