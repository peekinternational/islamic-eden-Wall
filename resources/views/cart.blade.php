@inject('cart', 'LukePOLO\LaraCart\LaraCart')
<?php $cart_items = 0; ?>
@foreach($cart->getItems() as $item)
    <?php $cart_items++; ?>
@endforeach
@extends('master')
@section('breadcrumb')
    @include('partials.breadcrumb')
@stop
@section('content')
    <div class="{{ isset($theme['theme']['value'])?$theme['theme']['value']:'ls' }} section_padding_top_75 section_padding_bottom_75 columns_padding_25 ">
        <div class="container">
            <div class="row cart-sectn ">
                 @include('partials.sidebar')
                <div class="col-sm-8 col-md-8 col-lg-8">
                    <div class="hidden-xs">
                        <div class="row cart-sectn" style="margin: 0 0 10px;">
                            <div class="col-md-3 col-xs-6">
                                <h5 class="product-info">Product</h5>
                            </div>
                            <div class="col-md-1 col-xs-6">
                                 <h5 class="product-info">Color</h5>
                             </div>
                             <div class="col-md-2 col-xs-6 text-center">
                                 <h5 class="product-info">Size</h5>
                             </div>
                             <div class="col-md-2 col-xs-6 text-center">
                                 <h5 class="product-info">Quantity</h5>
                             </div>
                             <div class="col-md-1 col-xs-6 text-center">
                                 <h5 class="product-info">Price</h5>
                             </div>
                             <div class="col-md-2 col-xs-6 text-center">
                                 <h5 class="product-info">Sub-total</h5>
                             </div>
                             <div class="col-md-1 text-center">
                                <h5 class="product-info">Action</h5>
                            </div>

                        </div>
                        @if(count($cart->getItems())>0)
                        @foreach($cart->getItems() as $item)
                        <div class="row cart-sectn" style="margin: 0 0 10px;">
                            <div class="col-md-3 col-xs-6">

                                <div class="row title-row">
                                    <div class="col-xs-4">
                                        <a href="{{ url('product/'.$item->slug)}}">
                                            <img class="media-object cart-product-image" src="{{  $item->image }}" alt="{{ $item->name }}" style="width: 100%;">
                                        </a>
                                    </div>
                                    <div class="col-xs-8">
                                        <h5 class="text-heading">
                                            <a href="{{ url('product/'.$item->slug)}}">{{ $item->name }}</a>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 col-xs-6">
                                 <span class="amount">{{ $item->color  }}</span>
                            </div>
                            <div class="col-md-2 col-xs-6 text-center">
                                 @if($item->p_size)
                                    <span class="amount">{{ $item->p_size  }}</span>
                                @else
                                    <span class="amount">{{ $item->p_dimension  }}</span>
                                @endif
                            </div>
                            <div class="col-md-2 col-xs-6 text-center">
                                 <div class="quantity">
                                     <input type="button" value="-" class="minus">
                                     <input style="text-align: center;" type="number" step="1" min="0" data-id="{{ $item->id }}" data-price="{{ $item->price }}"  name="product_quantity" value="{{ $item->qty }}" title="Qty" class="form-control input-product-quantity">
                                     <input type="button" value="+" class="plus">
                                 </div>
                            </div>
                            <div class="col-md-1 col-xs-6 text-center">
                                 <span class="currencies">€</span>
                                 <span class="amount">{{ $item->price }}</span>
                            </div>
                            <div class="col-md-2 col-xs-6 text-center">
                                  <span class="currencies">€</span>
                                 <span class="amount">{{ $item->price *  $item->qty  }}</span>
                            </div>
                            <div class="col-md-1 text-center">
                                 {!! Form::open(array('route' => array('cart.destroy', $item->id),'method' => 'delete')) !!}
                                 <button type="submit" class="remove fontsize_24" style="background: transparent; border: none;" title="Remove this item">
                                     <i class="rt-icon2-trash highlight"></i>
                                 </button>
                                 {!! Form::close() !!}
                            </div>
                        </div>
                            @endforeach
                        @else
                            <div class="cart_item row">
                                <div class="col-md-12" colspan="5">
                                    <p class="alert alert-warning text-center">
                                        Shopping Basket is empty.
                                    </p>
                                </div>
                            </div>
                        @endif
                        <div class="cart-buttons">
                        <a class="button-t1" href="{{ route('products') }}">Countinue Shopping</a>
                        <input type="submit" class="button-t1 btn-update-cart" name="update_cart" value="Update Cart">
                        <a class="button-t1" href="{{ route('cart.checkout') }}">Proceed to Checkout</a>
                    </div>
                    <div class="cart-collaterals">
                        <div class="cart_totals">
                            <h4>Shopping Basket Totals</h4>
                            <table class="table">
                                <tbody>
                                <tr class="cart-subtotal">
                                    <td>Shopping Basket Subtotal</td>
                                    <td>
                                        <span class="currencies">€</span>
                                        <span class="amount">{{ $cart->subTotal($format = false, $withDiscount = true) }}</span>
                                    </td>
                                </tr>
                                <tr class="shipping">
                                    <td>Shipping and Handling</td>
                                    <td>
                                        Free Shipping
                                    </td>
                                </tr>
                                <tr class="order-total">
                                    <td class="grey">Order Total</td>
                                    <td>
                                        <strong class="grey">
                                            <span class="currencies">€</span>
                                            <span class="amount">{{ $cart->total($format = false,$withDiscount = true) }}</span>
                                        </strong>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    </div>



                    <!-- mobile view start -->


                    <div class="hidden-md hidden-lg hidden-sm">

                                @if(count($cart->getItems())>0)
                                @foreach($cart->getItems() as $item)
                        <div class="row" style="margin: 0;">
                            <div class="col-xs-4">
                                <div class="row cart-sectn" style="margin: 0 0 10px;">
                                    <div class="col-xs-12">
                                        <h5 class="product-info">Product</h5>
                                    </div>
                                    <div class="col-xs-12">
                                         <h5 class="product-info">Color</h5>
                                     </div>
                                     <div class="col-xs-12">
                                         <h5 class="product-info">Size</h5>
                                     </div>
                                     <div class="col-xs-12">
                                         <h5 class="product-info">Quantity</h5>
                                     </div>
                                     <div class="col-xs-12">
                                         <h5 class="product-info">Price</h5>
                                     </div>
                                     <div class="col-xs-12">
                                         <h5 class="product-info">Sub-total</h5>
                                     </div>
                                     <div class="col-xs-12">
                                        <h5 class="product-info">Action</h5>
                                    </div>

                                </div>
                                
                            </div>
                            <div class="col-xs-8">
                                <div class="row cart-sectn" style="margin: 0 0 10px;">
                                    <div class="col-xs-12">

                                        <div class="row title-row">
                                            <div class="col-xs-4">
                                                <a href="{{ route('product.show',['slug'=>$item->id]) }}">
                                                    <img class="media-object cart-product-image" src="{{  $item->image }}" alt="{{ $item->name }}" style="width: 45%;">
                                                </a>
                                            </div>
                                            <div class="col-xs-8">
                                                <h5 class="text-heading">
                                                    <a href="{{ route('product.show',['slug'=>$item->id]) }}">{{ $item->name }}</a>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12" style="padding-top: 7px;">
                                         <span class="amount">{{ $item->color  }}</span>
                                    </div>
                                    <div class="col-xs-12"  style="padding-top: 7px;">
                                         @if($item->p_size)
                                            <span class="amount">{{ $item->p_size  }}</span>
                                        @else
                                            <span class="amount">{{ $item->p_dimension  }}</span>
                                        @endif
                                    </div>
                                    <div class="col-xs-12"  style="padding-top: 10px;">
                                         <div class="quantity">
                                             <input type="button" value="-" class="minus">
                                             <input type="number" step="1" min="0" data-id="{{ $item->id }}" data-price="{{ $item->price }}"  name="product_quantity" value="{{ $item->qty }}" title="Qty" class="form-control input-product-quantitys">
                                             <input type="button" value="+" class="plus">
                                         </div>
                                    </div>
                                    <div class="col-xs-12" style="padding-top: 7px;">
                                         <span class="currencies">€</span>
                                         <span class="amount">{{ $item->price }}</span>
                                    </div>
                                    <div class="col-xs-12" style="padding-top: 15px;">
                                          <span class="currencies">€</span>
                                         <span class="amount">{{ $item->price *  $item->qty  }}</span>
                                    </div>
                                    <div class="col-xs-12" style="padding-top: 15px;">
                                         {!! Form::open(array('route' => array('cart.destroy', $item->id),'method' => 'delete')) !!}
                                         <button type="submit" class="remove fontsize_24" style="background: transparent; border: none;" title="Remove this item">
                                             <i class="rt-icon2-trash highlight"></i>
                                         </button>
                                         {!! Form::close() !!}
                                    </div>
                                </div>
                                    
                            </div>
                        </div>
                        @endforeach
                                @else
                                    <div class="cart_item row">
                                        <div class="col-md-12" colspan="5">
                                            <p class="alert alert-warning text-center">
                                                Shopping Basket is empty.
                                            </p>
                                        </div>
                                    </div>
                                @endif
                                 <div class="cart-buttons">
                        <a class="button-t1" href="{{ route('products') }}">Countinue Shopping</a>
                        <input type="submit" class="button-t1 btn-update-carts" name="update_cart" value="Update Cart">
                        <a class="button-t1" href="{{ route('cart.checkout') }}">Proceed to Checkout</a>
                    </div>
                    <div class="cart-collaterals">
                        <div class="cart_totals">
                            <h4>Shopping Basket Totals</h4>
                            <table class="table">
                                <tbody>
                                <tr class="cart-subtotal">
                                    <td>Shopping Basket Subtotal</td>
                                    <td>
                                        <span class="currencies">€</span>
                                        <span class="amount">{{ $cart->subTotal($format = false, $withDiscount = true) }}</span>
                                    </td>
                                </tr>
                                <tr class="shipping">
                                    <td>Shipping and Handling</td>
                                    <td>
                                        Free Shipping
                                    </td>
                                </tr>
                                <tr class="order-total">
                                    <td class="grey">Order Total</td>
                                    <td>
                                        <strong class="grey">
                                            <span class="currencies">€</span>
                                            <span class="amount">{{ $cart->total($format = false,$withDiscount = true) }}</span>
                                        </strong>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                        
                    </div>


                    <!-- <div class="table-responsive">
                        <table class="table cart-table">
                            <thead>
                            <tr>
                                <td class="product-info">Product</td>
                                <td class="product-price-td">Color</td>
                                <td class="product-price-td">Size/Dimension</td>
                                <td class="product-quantity">Quantity</td>
                                <td class="product-price-td">Price</td>
                                <td class="product-subtotal">Subtotal</td>
                                <td class="product-remove">&nbsp;</td>
                            </tr>
                            </thead>
                            <tbody>
                                @if(count($cart->getItems())>0)
                                    @foreach($cart->getItems() as $item)
                                        <tr class="cart_item">
                                            <td class="product-info">
                                                <div class="media">
                                                    <div class="media-left">
                                                        <a href="{{ route('product.show',['slug'=>$item->id]) }}">
                                                            <img class="media-object cart-product-image" src="{{  $item->image }}" alt="{{ $item->name }}">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <h4 class="media-heading">
                                                            <a href="{{ route('product.show',['slug'=>$item->id]) }}">{{ $item->name }}</a>
                                                        </h4>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="product-subtotal">
                                                
                                               <span class="amount">{{ $item->color  }}</span>
                                            </td>
                                            <td class="product-subtotal">
                                                @if($item->p_size)
                                               <span class="amount">{{ $item->p_size  }}</span>
                                               @else
                                               <span class="amount">{{ $item->p_dimension  }}</span>
                                               @endif
                                            </td>
                                            <td class="product-quantity">
                                                <div class="quantity">
                                                    <input type="button" value="-" class="minus">
                                                    <input type="number" step="1" min="0" data-id="{{ $item->id }}" data-price="{{ $item->price }}"  name="product_quantity" value="{{ $item->qty }}" title="Qty" class="form-control input-product-quantity">
                                                    <input type="button" value="+" class="plus">
                                                </div>
                                            </td>
                                            <td class="product-price">
                                           
                                                <span class="currencies">€</span>
                                                <span class="amount">{{ $item->price }}</span>
                                                
                                            </td>
                                            
                                            <td class="product-subtotal">
                                                <span class="currencies">€</span>
                                               <span class="amount">{{ $item->price *  $item->qty  }}</span>
                                            </td>
                                            <td class="product-remove">
                                                {!! Form::open(array('route' => array('cart.destroy', $item->id),'method' => 'delete')) !!}
                                                <button type="submit" class="remove fontsize_24" style="background: transparent; border: none;" title="Remove this item">
                                                    <i class="rt-icon2-trash highlight"></i>
                                                </button>
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="cart_item">
                                        <td colspan="5">
                                            <p class="alert alert-warning text-center">
                                                Shopping Basket is empty.
                                            </p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div> -->
                    
                    {{--<div class="row">
                        <div class="col-sm-6">
                            <div class="coupon with_padding muted_background">
                                <h3 class="topmargin_0">Discount Codes</h3>
                                <p>Enter coupon code if you have one</p>
                                <div class="form-group">
                                    <label class="sr-only" for="coupon_code">Coupon:</label>
                                    <input type="text" name="coupon_code" class="form-control" id="coupon_code" value="" placeholder="Coupon code">
                                </div>
                                <a class="button-t1" href="#">Apply Coupon</a>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="shipping-calculator-form with_padding muted_background">
                                <h3 class="topmargin_0">Shipping &amp; Tax</h3>
                                <p>Enter destination to get shipping</p>
                                <div class="form-group">
                                    <select name="calc_shipping_country" id="calc_shipping_country" class="country_to_state form-control">
                                        <option value="">Select a country…</option>
                                        <option value="AX">Åland Islands</option>
                                        <option value="OM">Oman</option>
                                        <option value="GB" selected="selected">United Kingdom (UK)</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" value="" placeholder="State / county" name="calc_shipping_state" id="calc_shipping_state">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" value="" placeholder="Postcode / Zip" name="calc_shipping_postcode" id="calc_shipping_postcode">
                                </div>
                                <div>
                                    <button type="submit" name="calc_shipping" class="button-t1" value="1">Update Totals</button>
                                </div>
                            </div>
                        </div>
                    </div>--}}
                </div>

                <!-- sidebar -->
               
                <!-- eof aside sidebar -->
                
            </div>

        </div>
    </div>
@stop
@section('scripts')
        <script>
            $(document).ready(function () {
                $('.cart-table').on('change','input', function () {
                   // alert();
                    //$(this).parents('.product-quantity').siblings('.product-subtotal').find('.amount').html('43');
                });

                $('.btn-update-cart').click(function () {
                    var products = {};
                    var index = 0;
                    $('.input-product-quantity').each(function () {
                        products[index] = {
                            id: $(this).attr('data-id'),
                            p_price: $(this).attr('data-price'),
                            quantity:$(this).val()
                        };
                        index++;
                    });
                    $.ajax({
                        url:'{{ url('cart/update/all') }}',
                        type:'post',
                        dataType:'json',
                        data:{
                            _token: "{{ csrf_token() }}",
                            products : products
                        },
                        success: function (result) {
                            console.log(result.notify);
                            if(result.notify!=null){
                                $.notify(result.notify, result.type);
                                setTimeout(function () {
                                    location.reload();
                                },1000);
                            }
                        },
                        error: function(error){
                            console.log(error);
                        }
                    });
                });
            });

             $('.btn-update-carts').click(function () {
                    var products = {};
                    var index = 0;
                    $('.input-product-quantitys').each(function () {
                        products[index] = {
                            id: $(this).attr('data-id'),
                            p_price: $(this).attr('data-price'),
                            quantity:$(this).val()
                        };
                        index++;
                    });
                    $.ajax({
                        url:'{{ url('cart/update/all') }}',
                        type:'post',
                        dataType:'json',
                        data:{
                            _token: "{{ csrf_token() }}",
                            products : products
                        },
                        success: function (result) {
                            console.log(result.notify);
                            if(result.notify!=null){
                                $.notify(result.notify, result.type);
                                setTimeout(function () {
                                    location.reload();
                                },1000);
                            }
                        },
                        error: function(error){
                            console.log(error);
                        }
                    });
                });
           
        </script>
@stop