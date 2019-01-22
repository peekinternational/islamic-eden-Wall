<?php

namespace Edenmill\Http\Controllers;

use Edenmill\Gallery;
use Edenmill\Products;
use Edenmill\Slider;
use Edenmill\Blog;
use Illuminate\Http\Request;

use Edenmill\Http\Requests;
use DB;

class MainController extends Controller
{
        public function home_page(Request $request){
                 $slides = Slider::orderBy('order_by','asc')->get();

             
             $latest_products = Products::join('product_dimension','product_dimension.product_id','=','products.id')
                ->join('product_images','product_images.product_id','=','products.id')
               ->where('product_dimension.dim_offer','!=','null')

                ->where('products.offer','=','')->groupBy('product_dimension.product_id')->orderBy('products.id','desc')->limit(5)->get()->toArray();


               $latest_products2 = Products::join('product_dimension','product_dimension.product_id','=','products.id')
                ->join('product_images','product_images.product_id','=','products.id')
                ->whereNull('product_dimension.dim_offer')

                ->where('products.offer','=','')->groupBy('product_dimension.product_id')->orderBy('products.id','desc')->limit(5)->get()->toArray();


                
               //dd($latest_products2);
                // $product_dimension  = DB::table('product_dimension')->where('product_id','=',$latest_products->id)->get();
            
                $gallery = Gallery::all();
                $posts =  Blog::orderBy('publish_at','desc')->limit(5)->get();
               // dd($posts);
                return view('index',compact('slides','latest_products','gallery','posts','latest_products2'));
        }

}
