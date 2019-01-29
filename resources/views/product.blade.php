@extends('master')
@section('breadcrumb')
    @include('partials.breadcrumb')
@stop
@section('content')

    <div class="{{ isset($theme['theme']['value'])?$theme['theme']['value']:'ls' }} section_padding_top_100 section_padding_bottom_100">
        <div class="container">
            <div class="row product-page-responsive">
                @include('partials/sidebar')
                 <ul class="breadcrumb" style="float: left !important">
                        <li><a href="#">Home</a></li>
                        <li><a href="{{ url('products')}}">{{$products[0]->category->name }}</a></li>
                        <li>{{ $product->name }}</li>
                  </ul>

                <div class="col-sm-8">
                   <div class="shop-single">
                        <figure class="shop-single__img">
                            @if($product->images->count()>0)
                            
                                <div class="format-gallery"  style="border: 1px solid lightgrey" >
                                    <div class="entry-thumbnail">
                                        <div id="carousel-generic" class="carousel slide">
                                            <div class="carousel-inner"  id="description">
                                                @foreach($product->images as $key => $image)

                                                <div style="text-align: center;" class="item {{ $key==0?'active':'' }}  product-detail-img tile"  data-scale="2.4"  data-image="{{ asset('assets/images/products/'.$image->image)}}">
                                                    <img
                                                    src="{{ asset('assets/images/products/'.$image->image) }}" alt="{{ $product->name }}" id="largeImage ">
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <img src="{{  asset('assets/images/no-image.png') }}" alt="{{ $product->name }}">
                            @endif
                            <div style="margin-top:11px; margin-bottom: 11px; text-align: center; " id="thumbs">
                            @foreach($product->images as $key => $image)
                           <img src="{{ asset('assets/images/products/'.$image->image) }}" alt="{{ $product->name }}" style="width:50px; margin-right: 2px; height: 50px; border: 1px solid blue">
                            @endforeach
                            </div>
                        </figure>
                        <div class="shop-single__content">
                            <ul class="shop-item__meta-list">
                            <li>
                                    <h3 class="shop-item__title">
                                        {{ $product->name }}
                                    </h3>
                                </li>
                                
                                @if($product->tags->count()>0)
                                    <li>
                                        <a class="shop-item__meta-tag" href="{{ action('CategoryController@show',str_slug($product->category->name)) }}">{{ $product->category->name }}</a>
                                    </li>
                                @endif
                             
                            </ul>
                           <span class="price">
                                <span>
                                 @if($product_dimension->count()>0)

                                 @if($product_dimension[0]->dim_offer)
                                  <?php 
                                  $min = $product_dimension->min('p_price');
                                  $max = $product_dimension->max('p_price');
                               
                                  $offer_min = $product_dimension->min('dimoffer_price');
                                  $offer_max = $product_dimension->max('dimoffer_price');
                                
                                 ?>
                                 <span class="amount" style="color: gray !important; font-size: 26px;">&euro;<strike><small>{{ $min }} - {{$max}}</small></strike></span><br>
                                 <span class="amount" id="show_price" style="color: gray !important; font-size: 26px;">&euro;{{ $offer_min }} - {{$offer_max}}</span>
                                 <span>&nbsp;  {{$product_dimension[0]->dim_offer}} %</span>
                                 @else
                                <?php 
                                  $min = $product_dimension->min('p_price');
                                  $max = $product_dimension->max('p_price');
                               
                                 ?>
                                 <span class="amount" id="show_price" style="color: gray !important; font-size: 26px;">&euro;{{ $min }} - {{$max}}</span><br>
                                 @endif

                                 @else

                                 @if($product->offer)
                                <span class="amount  pro-prce" style="color: gray !important; font-size: 26px;">&euro;<strike><small>{{ $product->price }}</small></strike></span>
                               <span class="amount" style="color: gray !important; font-size: 26px;">&euro;{{ $product->saleprice }}</span>
                                 @else
                                    <span class="amount" id="show_price" style="color: black !important; font-size: 26px;">&euro;{{ $product->price }}</span>
                               
                               @endif
                               @endif
                                </span>
                            </span>
                               
                         
                            @if($product->tags->count()>0)
                                <p class="shop-tags" style="border: none;margin: 0;">
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
                                
                                    <div class="shop-tags" style="display: -webkit-box;border: none;margin: 0;">
                                    <span>Color:</span>
                                    @foreach($product_color as $key=>$color)
                                    <input id="checkboxid{{$color->id}}" onclick="colorselect({{$color->id}})" name="color" type="checkbox" value="{{$color->color}}" class="css-checkbox onlyone color">
                                     <label for="checkboxid{{$color->id}}" class="css-label">{{ucfirst($color->color)}}</label>
                                        @if(($key+1)< $product_color->count())
                                                	&nbsp;&nbsp;
                                       @endif
                                    @endforeach
                                    </div>
                               
                            @endif
                            @if($product_size->count()>0)
                                 
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
                                
                            @endif

                             @if($product_dimension->count()>0)
                                 
                                     <div style="display: -webkit-box;">
                                    <span>Size:</span>
                                   @foreach($product_dimension as $key=>$dimension)
                                    
                                    @if($dimension->dim_offer)
                                    <input id="checkdem{{$dimension->id}}" onclick="dimensionselect({{$dimension->id}},{{$dimension->dimoffer_price}})" type="radio" name="p_dimension" value="{{$dimension->p_dimension}}" class="css-checkbox onlyone">
                                      @else
                                       <input id="checkdem{{$dimension->id}}" onclick="dimensionselect({{$dimension->id}},{{$dimension->p_price}})" type="radio" name="p_dimension" value="{{$dimension->p_dimension}}" class="css-checkbox onlyone">
                                       @endif
                                       <label for="checkdem{{$dimension->id}}" class="css-label">{{strtoupper( $dimension->p_dimension)}}</label>
                                        @if(($key+1)< $product_size->count())
                                                   	&nbsp;&nbsp;
                                        @endif
                                    @endforeach
                                    </div>
                                
                            @endif
                           
                               
                            <div class="quantity-btn">
                           <p id="selcol"> </p>
                                {!! Form::open(['route'=>['cart.update',$product->id],'method'=>'put','class'=>'single-shop-item__gty']) !!}

                                        <span class="quantity form-group">
                                                <input type="button" value="-" class="minus">
                                                <input type="number" step="1" min="0" name="quantity" value="{{ $quantity }}" title="Qty" id="product_quantity" class="form-control ">
                                                <input type="button" value="+" class="plus">
                                                <input type="hidden" name="color" id="sel_color">
                                                <input type="hidden" name="p_size" id="sel_size">
                                                <input type="hidden" name="p_dimension" id="sel_dim">
                                                <input type="hidden" name="p_price" id="sel_price">
                                        </span>
                                        <button class="button-t1" type="submit" id="addcart">Add to cart</button>
                                       
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
                                    <a href="#descript" aria-controls="home" role="tab" data-toggle="tab">Description</a>
                                </li>
                                <li role="presentation">
                                    <a href="#Additional-info" aria-controls="tab" role="tab" data-toggle="tab">Additional Information</a>
                                </li>
                            </ul>
                        
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="descript">
                                  {!! $product->description !!}</div>
                                <div role="tabpanel" class="tab-pane" id="Additional-info">
                                  {!! $product->Addtional_Information !!}</div>
                            </div>
                        </div>
                       
                    </div>
                </div>
                
                <div class="col-lg-12">
                    <div id="itemSlider">
                        <div class="col-md-12 " style="display: block !important;" >
                            <h2 class="text-center title-product"> realated Product</h2>
                            <div class="">
                                @foreach($products as $product)
                                <div class="col-md-2 col-sm-12 category-img  respnsve-img-pro" >
                                    <a class="img-height" href="{{ url('product/'.$product->slug) }}" class="">
                                        @if($product->images->count()>0)
                                            <img src="{{ asset('assets/images/products/'.$product->images->first()->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%">
                                             
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

                                        @if($product->dimension)
                                
                                            @if($product->dimension[0]->dim_offer)
                                        
                                            <p class="text-center" style="margin-bottom: 0px; color: red;">{{ $product->dimension[0]->dim_offer }} % off</p>
                                            <p class="text-center"> <strike style="padding: 0px 8px;"><small>€{{ $product->dimension[0]->p_price }}</small> </strike>
                                            <span> €{{ $product->dimension[0]->dimoffer_price }}</span></p>
                                            
                                         @else
                                        
                                            <p class="text-center"> €{{ $product->dimension[0]->p_price }} </p>
                                        @endif
                                

                                      @else
                                          @if($product->offer)
                                          <p class="text-center" style="margin-bottom: 0px; color: red;">{{ $product->offer }} % off</p>
                                                <p class="text-center"> <strike style="padding: 0px 8px;"><small>€{{ $product->price }}</small> </strike>
                                                <span> €{{ $product->saleprice }}</span></p>
                                                  @else
                                                <p class="text-center"> €{{ $product->price }} </p>
                                                @endif
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
$(document).ready(function() {
   

 });
  $("form.single-shop-item__gty").submit(function(e){
  if($('#sel_color').val() != '' && $('#sel_dim').val() != '' || $('#sel_size').val() != ''){
         
     return true;
      }else{

          $('#selcol').html('<span style="color:red">Please Select Color/Size</span>');

          e.preventDefault();
          return false;
      }
        
    });
  $('.color').click(function() {
		 
        if($(this).val() != '' && $('#sel_dim').val() != '' || $('#sel_size').val() != '') {
           $('#selcol').hide();
        }
     });
 </script>
    <script>
        $('#thumbs img').click(function(){
          var imgsrc=$(this).attr('src');
           var html= ' <div class="item active  product-detail-img tile"   data-scale="2.4" '+
            'data-image="'+imgsrc+'">'+
             '<img src="'+imgsrc+'" alt="{{ $product->name }}" id="largeImage">'+
                   '</div>';
    
    $('#description').html(html);
    });

        $('.tile')
          // tile mouse actions
          .on('mouseover', function(){
            $(this).children('.photo').css({'transform': 'scale('+ $(this).attr('data-scale') +')'});
          })
          .on('mouseout', function(){
            $(this).children('.photo').css({'transform': 'scale(1)'});
          })
          .on('mousemove', function(e){
            $(this).children('.photo').css({'transform-origin': ((e.pageX - $(this).offset().left) / $(this).width()) * 100 + '% ' + ((e.pageY - $(this).offset().top) / $(this).height()) * 100 +'%'});
          })
          // tiles set up
          .each(function(){
            $(this)
              // add a photo container
              .append('<div class="photo"></div>')
              // some text just to show zoom level on current item in this example
              
              // set up a background image for each tile based on data-image attribute
              .children('.photo').css({'background-image': 'url('+ $(this).attr('data-image') +')'});
          })

   function dimensionselect(id, price){
       //alert(price);
       $('#show_price').html('€'+price);
       var data= $('#checkdem'+id).val();
      // alert(price);
           $('#sel_dim').val(data);
           $('#sel_price').val(price);

   }
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