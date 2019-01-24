<?php

namespace Edenmill\Http\Controllers;

use Illuminate\Http\Request;
use Edenmill\Products;
use Edenmill\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use LukePOLO\LaraCart\LaraCart;
use Lykegenes\LaravelCountries\Facades\Countries as Countries;
use DB;

class CartController extends Controller
{
        /**
         * Display a listing of the Cart.
         *
         * @return \Illuminate\Http\Response
         */
        public function index(LaraCart $cart){

                return view('cart');
        }

        /**
         * Store a newly created item in cart.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request,LaraCart $cart)
        {
            //dd($request->all());
                if(!$request->has('id') && !((int)$request->input('id'))>0){
                        $request->session()->flash('__response', ['message'=>'Oops! Something went wrong.','type'=>'danger']);
                }else{
                        $product_id = (int)$request->input('id');
                        $find = $cart->find(['id' => $product_id]);
                        $product = Products::findOrFail($product_id);
                        if($product->offer){
                        $final_price= $product->saleprice; 
                        }
                        else
                        {
                        $final_price= $product->price;    
                        }
                        if(is_array($find) && !count($find)>0){
                                $cart->add(
                                        $product_id,
                                        $name = $product->name,
                                        $qty = 1,
                                        $price = (float)$final_price,
                                        $options = [
                                                'image'=>'assets/images/'.($product->images()->count()?'products/'.$product->images->first()->image:'no-image.png'),
                                                'slug'=> $product->slug
                                        ],
                                        $taxable = false,
                                        $lineItem = false
                                );
                              // dd($cart); 
                        }else if(is_array($find) && count($find)>0){
                              $item = $find[0];
                              $itemHashId =  $item->getHash();
                              $quantity  = (int)$item->qty;
                              $quantity++;
                                $cart->updateItem($itemHashId,'qty', $quantity);
                                $cart->updateItem($itemHashId,'price', (float)$product->price);

                        }
                        $request->session()->flash('__response', ['notify'=>'Product "'.$product->name.'" successfully added to cart.','type'=>'success']);
                }
                return Redirect::back();
        }

        /**
         * Remove the specified item from cart.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function destroy($id,Request $request,LaraCart $cart)
        {        $id = (int)$id;
                if(!$id>0){
                        $request->session()->flash('__response', ['message'=>'Oops! Something went wrong.','type'=>'danger']);
                }else{
                        $find = $cart->find(['id' => $id]);
                        if(is_array($find) && count($find)>0){
                               $item = $find[0];
                                $itemHashId =  $item->getHash();
                                $cart->removeItem($itemHashId);
                                $request->session()->flash('__response', ['notify'=>'Product "'.$item->name.'" successfully removed from cart.','type'=>'success']);
                        }
                }
                return Redirect::back();
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, $id,LaraCart $cart)
        {
        //        /dd($request->input('p_size'));
                 $color=$request->input('color');
                 $size=$request->input('p_size');
                 $p_dimension=$request->input('p_dimension');
                 $p_price=$request->input('p_price');
                $product_id = (int)$id;
                if(!$request->has('quantity') || !$request->quantity >0 ||  !$product_id>0){
                        $request->session()->flash('__response', ['notify'=>'Oops something went wrong.','type'=>'error']);
                        return Redirect::back();
                }
                $find = $cart->find(['id' => $product_id]);
                $product = Products::findOrFail($product_id);
                if($p_price){
                  $final_price=$p_price;
                }else{
                      if($product->offer){
                              $final_price= $product->saleprice; 
                           }
                         else
                            {
                               $final_price= $product->price;    
                             }
                      }
                $quantity = (int)$request->quantity;
                if(is_array($find) && !count($find)>0){
                        $cart->add(
                                $product_id,
                                $name = $product->name,
                                $qty = $quantity,
                                $price = (float)$final_price,
                                $options = [
                                        'image'=>'assets/images/'.($product->images()->count()?'products/'.$product->images->first()->image:'no-image.png'),
                                        'slug'=> $product->slug,
                                        'color'=>$color,
                                        'p_size'=>$size,
                                        'p_dimension'=>$p_dimension
                                ],
                                $taxable = true,
                                $lineItem = false
                        );
                }else if(is_array($find) && count($find)>0){
                        $item = $find[0];
                        $itemHashId =  $item->getHash();
                        $cart->updateItem($itemHashId,'qty', $quantity);
                        $cart->updateItem($itemHashId,'price', (float)$final_price);
                }
                $request->session()->flash('__response', ['notify'=>'Product "'.$product->name.'" successfully added to cart.','type'=>'success']);
                return Redirect::back();

        }


        public function update_all(Request $request,LaraCart $cart){
                //dd($request->all());
                if(!$request->has('products') && is_array($request->input('products')) && count($request->input('products'))>0){
                        return json_encode(['notify'=>'Oops something went wrong.','type'=>'error']);
                }
                foreach($request->input('products') as $product){
                        if(isset($product['id']) && isset($product['quantity'])){
                                $product_id = (int)$product['id'];
                                $p_price = $product['p_price'];
                                $find = $cart->find(['id' => $product_id]);
                                $db_product = Products::findOrFail($product_id);
                               // dd($p_price);
                                  if($p_price){
                                   $final_price=$p_price;
                                 }else{
                                  if($db_product->offer){
                                   $final_price= $db_product->saleprice; 
                                   }
                                else
                                  {
                                      $final_price= $db_product->price;    
                                  }
                                }
                                $quantity = $product['quantity'];
                                if(is_array($find) && !count($find)>0){
                                        $cart->add(
                                                $product_id,
                                                $name = $db_product->name,
                                                $qty = $quantity,
                                                $price = (float)$final_price,
                                                $options = [
                                                        'image'=>'assets/images/'.($db_product->images()->count()?'products/'.$db_product->images->first()->image:'no-image.png'),
                                                        'slug'=> $db_product->slug
                                                ],
                                                $taxable = false,
                                                $lineItem = false
                                        );
                                }else if(is_array($find) && count($find)>0){
                                        $item = $find[0];
                                        $itemHashId =  $item->getHash();
                                        $cart->updateItem($itemHashId,'qty', $quantity);
                                        
                                        $cart->updateItem($itemHashId,'price', (float)$final_price);

                                }
                        }
                }
                return json_encode(['notify'=>'Cart updated successfully.','type'=>'success']);
        }


        /**
         * Process Cart checkout.
         *
         * @return \Illuminate\Http\Response
         */
        public function checkout(LaraCart $cart){
                if(!count($cart->getItems())>0){
                        return redirect('/');
                }
                // dd($order_products);
                $countries = Countries::getListForDropdown('cca2', false, 'eng');
                return view('checkout',compact('countries','order_products'));
               
        }

        public function couponcode(Request $request , LaraCart $cart){
               $code=$request->input('coupon_code');
              $cd = DB::table('couponcode')->where('code','=',$code)->where('expiry_date','>=',date("Y-m-d"))->first();
			  
              $total=$cart->total($format = false, $withDiscount = true);
              $discount=0;
			  if($cd){
			  if($cd->type == 'fixed'){
				   $discount=$cd->discount;
                $coupon = new \LukePOLO\LaraCart\Coupons\Fixed($cd->code, $cd->discount, [
							'description' => 'apply code'
				]);

				$cart->addCoupon($coupon);
              }
			  else if($cd->type == 'percent'){
				   $discount=$cd->discount/100*$total;
                   
				  
				  $netdiscount=$cd->discount/100;
                 $coupon = new \LukePOLO\LaraCart\Coupons\Percentage($cd->code, $netdiscount, [
					'name'        => $cd->discount,
					'description' => $cd->discount.''.$cd->code,
				]);

				$cart->addCoupon($coupon);
              }
			  
             
               $request->session()->put('coupon',[
                       'name'=>$cd->code,
                       'discount' =>$discount,
               ]);
               $request->session()->flash('alert-success', 'Coupon apply successfully');
               return redirect()->route('cart.checkout');
			  }
			  else{
				  $request->session()->flash('alert-danger', 'Coupon Code Not Match!');
				    return redirect()->route('cart.checkout');
			  }
        }

        public function giftVoucherCheckout(Request $request){
                if($request->has('price') && $request->input('price')>0 && ($request->has('type') && ($request->input('type')=='e_voucher' || $request->input('type')=='e_voucher') && $request->has('quantity') && $request->input('quantity')>0)){
                         $countries = Countries::getListForDropdown('cca2', false, 'eng');
                         return view('checkout-gift-vouchers',compact('countries'));
                }else{
                        session()->flash('__response', ['notify'=>'Oops! Something went wrong.','type'=>'error']);
                        return redirect()->action('GiftVouchersController@showPage');
                }
               
        }
}
