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
                $latest_products = Products::latest(10)->get();
                 foreach($latest_products as &$rec){
                  $rec->dimension=DB::table('product_dimension')->where('product_id','=',$rec->id)->get()->toArray();
                  // dd($rec->dimension);

                }
               $latest_products2 = Products::where('offer','!=',"")->latest(10)->get();
                 foreach($latest_products2 as &$rec){
                  $rec->dimension=DB::table('product_dimension')->where('product_id','=',$rec->id)->get()->toArray();

                }
                //dd($latest_products);
                // $product_dimension  = DB::table('product_dimension')->where('product_id','=',$latest_products->id)->get();
            
                $gallery = Gallery::all();
                $posts =  Blog::orderBy('publish_at','desc')->limit(5)->get();
               // dd($posts);
                return view('index',compact('slides','latest_products','gallery','posts','latest_products2'));
        }

}
