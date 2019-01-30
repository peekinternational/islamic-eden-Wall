@extends('dashboard.layouts.default')
@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <section class="content">
        <div class="{{ isset($theme['theme']['value'])?$theme['theme']['value']:'ls' }} section_padding_top_120 section_padding_bottom_85">
        <div class="container responsive">
            <div class=" row box-header with-border">
              <div class="col-sm-8 col-md-9 col-lg-9" style="margin-left: 10px;">
                <div class="row" style="margin-bottom: 12px;">
                 <form action="{{ action('ProductController@getIndex')}}" method="post" >
                {!! csrf_field() !!}
                    <div class="col-md-4" style="padding: 0px 0px;">
                      <select class="form-control" name="catid">
                       <option value = "">select Category</option>
                       @foreach($category as $cat)
                       <option value ="{{$cat->id}}">{{$cat->name}}</option>
                       @endforeach
                       </select>
                    </div>
                    <div class="col-md-4">
                       <button style="padding: 7px 12px !important;" class="btn btn-xs">Search</button>
                    </div>
                    <div class="box-tools pull-right  col-offset-md-2 col-md-2">
                    <a href="{{ action('ProductController@create') }}" type="button" class="btn btn-box-tool"  data-toggle="tooltip" title="New Product">
                        <i class="fa fa-plus"></i>
                    </a>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
               
                </form>   
                </div>
               
            </div>
            <div class="box-body">
                @include('dashboard.partials.formErrorMessage')
                 <ul id="products" class="products list-unstyled grid-view">
                    @foreach($products as $key=>$product)
                    <li class="shop-itemm product type-product item-list">

                        <div class="editi_res">
                            <figure class="item-media shop-item__img">
                                <a href="{{ url('product/'.$product->slug) }}">
                                    <?php
                                        $first_image = $product->images->first();
                                        $image = 'no-image.png';
                                            if(isset($first_image->image) && !empty($first_image)){
                                                $image = 'products/'.$first_image->image;
                                            }
                                    ?>
                                <div class="image-list">
                                    <img src="{{  asset('assets/images/'.$image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; position: relative;
                                         ">
                                         <div style="position: absolute; top: 57%; left:38%;">
                                                 <a href="{{ url('product/'.$product->slug) }}" class="btn btn-xs btn-info" data-toggle="tooltip"  data-original-title="View Product"><i class="fa fa-search"></i> </a>
                            <span class="btn-edit">
                                    <a href="{{ action('ProductController@edit',$product->id) }}" class="btn btn-xs btn-warning" data-toggle="tooltip"  data-original-title="Edit"><i class="fa fa-edit"></i> </a>
                                   <a href="{{ action('ProductController@copy',$product->id) }}" type="submit" class="btn btn-xs btn-danger btn-delete-user" data-toggle="tooltip"   data-original-title="copy"><i class="fa fa-copy"></i></a>
                                    {!! Form::open(['action'=>['ProductController@destroy',$product->id],'method'=>'delete', 'id'=>'ids'.$product->id,'style'=>'display:inline;']) !!}
                                   <input type="hidden" class="delete_permanent" name="delete_permanent" value="0">
                                    <a href="javascript:void(0);" type="submit" class="btn btn-xs btn-danger btn-delete-user" data-toggle="tooltip"  onclick="remove_recordss('{{$product->id}}')"  data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
                                    
                                    {!! Form::close() !!}
                            </span>
                                         </div>
                                       
                                </div>
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
                                   <!--  <p class="description-dash">{{ $product->description }}</p> -->
                                   
                                 <p class="shop-item__price">
                                 
                            @if($product->dimension)
                            @if(!$product->dimension[0]->dim_offer)
                           
									  <span class="amount" id="show_price" style="color: gray !important; font-size: 26px;">&euro;{{ $product->dimension[0]->p_price }}</span><br>
									
									@else
									 <span class="amount" id="show_price" style="color: gray !important; font-size: 26px;">&euro;<strike><small>{{ $product->dimension[0]->p_price }}</small></strike></span> -
									 <span class="amount" id="show_price" style="color: gray !important; font-size: 26px;">&euro;{{ $product->dimension[0]->dimoffer_price  }}</span><br>	
									
									 @endif
									 @else
									 
                                    @if($product->offer)
                                    <span class="amount  pro-prce" style="color: gray !important; font-size: 26px;">&euro;<strike><small>{{ $product->price }}</small></strike></span>
                                    <span class="amount" style="color: gray !important; font-size: 26px;">&euro;{{ $product->saleprice }}</span>
                                    @else
                                        <span class="amount  pro-prce" style="color: gray !important; font-size: 26px;">&euro;{{ $product->price }}</span>
                                    @endif
                                    @endif
                                     
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
                               
                            </div>
                        </div>
                    </li>
                        <!-- <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ strip_tags($product->description) }}</td>

                            <td>
                                <a href="{{ action('ProductController@show',$product->name) }}" class="btn btn-xs btn-info" data-toggle="tooltip"  data-original-title="View Product"><i class="fa fa-search"></i> </a>
                            <span class="pull-right">
                                    <a href="{{ action('ProductController@edit',$product->id) }}" class="btn btn-xs btn-warning" data-toggle="tooltip"  data-original-title="Edit"><i class="fa fa-edit"></i> </a>
                                    {!! Form::open(['action'=>['ProductController@destroy',$product->id],'method'=>'delete','style'=>'display:inline;']) !!}
                                        <input type="hidden" class="delete_permanent" name="delete_permanent" value="0">
                                    <button type="button" class="btn btn-xs btn-danger btn-delete-user" data-toggle="tooltip"  data-original-title="Delete"><i class="fa fa-trash-o"></i></button>
                                    {!! Form::close() !!}
                            </span>

                            </td>
                        </tr> -->
                    @endforeach
                    
                    <!--  </ul>
                    @if($products->isEmpty())
                        <tr>
                            <td colspan="7">
                                <p class="alert alert-warning text-center">
                                    Products not found.
                                </p>
                            </td>
                        </tr>
                    @endif -->
                </div>
             </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
                {{ $products->links() }}
            </div>
            <!-- /.box-footer-->
        </div>
    </div>
        <!-- /.box -->
    </section>
@stop
@section('footer')

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
   <!--  <script>
        $(document).on('click','.btn-delete-user', function () {
            var form = $(this).parents('form:first');

            $.confirm({
                icon: 'fa fa-trash-o',
                title: 'Delete Product!',
                closeIcon: true,
                animation: 'rotate',
                closeAnimation: 'rotate',
                content: 'Are you want to delete this product?',
                confirmButton: 'Yes',
                cancelButton: 'No',
                confirmButtonClass: 'btn-danger',
                cancelButtonClass: 'btn-info',
                confirm: function(){
                    if(!$('input#__delete_permanent').is(':checked')){
                        form.find('input.delete_permanent').attr('value','1');
                    }
                    form.submit();
                }
            });
        });
    </script> -->
@stop
