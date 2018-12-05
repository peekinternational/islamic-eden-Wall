<?php

namespace Edenmill\Http\Controllers;

use Edenmill\Gallery;
use Edenmill\Products;
use Edenmill\Slider;
use Edenmill\Blog;
use Illuminate\Http\Request;

use Edenmill\Http\Requests;

class MainController extends Controller
{
        public function home_page(Request $request){
                     $slides = Slider::orderBy('order_by','asc')->get();
                $latest_products = Products::latest(5)->get();
               // dd($latest_products);
                $gallery = Gallery::all();
                $posts =  Blog::orderBy('publish_at','desc')->limit(5)->get();
               // dd($posts);
                return view('index',compact('slides','latest_products','gallery','posts'));
        }

}
