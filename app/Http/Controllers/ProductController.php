<?php

namespace Edenmill\Http\Controllers;

use Edenmill\Categories;
use Edenmill\Category;
use Edenmill\ProductImages;
use Edenmill\SubNavs;
use Edenmill\Tags;
use Illuminate\Http\Request;
use LukePOLO\LaraCart\LaraCart;
use Edenmill\Http\Requests;
use Edenmill\Products;
use Edenmill\Blog;
use Intervention\Image\ImageManagerStatic as Image;
use DB;
class ProductController extends Controller
{

    protected $breadcrumb = array(
            'title'        => 'Products',
            'description'  => 'Manage products.',
            'page'         => ''
    );

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       /* $category = Category::first();
        $category->products;
        $produt = Products::first();
        $cat = $produt->category;
        return $category;*/
        $products = Products::orderBy('id','desc')->paginate(10);
         return view('products',compact('products'));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $this->breadcrumb['page']  = 'Products List';
        $breadcrumb = $this->breadcrumb;
        $products = Products::orderBy('id','desc')->paginate(10);
        return view('dashboard.products.index',compact('products','breadcrumb'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->breadcrumb['page']  = 'New Products';
        $breadcrumb = $this->breadcrumb;
        $tags = Tags::pluck('name','id');
        $categories = Category::pluck('name','id');
       return view('dashboard.products.create',compact('breadcrumb','tags','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
     //dd($request->all());
        
        
        if(!$request->has('slug')){
            $request->merge(['slug'=>str_slug($request->input('name'))]);
        }
        $this->validate($request,[
            'name' => 'required',
            'category_id'=>'required',
            'navs' => 'required',
            'slug' => 'unique:products'
        ],[],[
            'name' => 'title',
            'category_id'=>'Category'
        ]);

        
       $size=$request->input('p_size');
       $p_color=$request->input('color');
       $p_dimension=$request->input('p_dimension');
       $p_price=$request->input('p_price');
       //dd($p_price[0]);
       $dim_offer=$request->input('dim_offer');
       

        $product = Products::create($request->all());
        if($product->id){

            $product->navs()->attach($request->input('navs'));
            if($request->has('tags')){
                $product->tags()->attach($request->input('tags'));
            }
            if($request->hasFile('photos')) {
                $photos = $request->file('photos');
                
                   /* $extension = $photo->extension();
                    $filename = md5(str_shuffle(time())) . md5(time()) . '.' . $extension;
                    $path = public_path('assets/images/products/' . $filename);
                    Image::make($photo->getRealPath())->resize(220, 220)->save($path);*/
                    $extension = $photos->getClientOriginalExtension();
                    $filename = md5(str_shuffle(time())).md5(time()).'.'.$extension;
                    $path = public_path('assets/images/products/');
                    $photos->move($path , $filename );

                    $image = ProductImages::create(['product_id' => $product->id, 'image' => $filename]);
                    
                
            }
              foreach($p_color as $colors )
              {
                  $input['color']=$colors;
                  $input['product_id']=$product->id;
                  DB::table('product_color')->insert($input);
              }

              if($size){
              foreach($size as $pro_size )
              {
                  $inputs['p_size']=$pro_size;
                  $inputs['product_id']=$product->id;
                  DB::table('product_size')->insert($inputs);
              }
             }
              if($dim_offer){
                      
                   foreach($p_price as $key=>$price){
                                $original_price = $price;
                                $discountprice=$original_price/100*$dim_offer;
                                $saledec =$original_price-$discountprice;
                                $sale =round($saledec);
                                $inputsss['p_price']=$price;
                                $inputsss['dimoffer_price']=$sale;
                                $inputsss['dim_offer']=$dim_offer;
                                $inputsss['p_dimension']=$p_dimension[$key];
                                $inputsss['product_id']=$product->id;
                                DB::table('product_dimension')->insert($inputsss);
                            }
                        }elseif($p_price[0] !=''){   
                                foreach($p_price as $key=>$price){
                                $inputss['p_price']=$price;
                                $inputss['p_dimension']=$p_dimension[$key];
                                $inputss['product_id']=$product->id;
                                DB::table('product_dimension')->insert($inputss);
                        }
                  }

         session()->flash('__response', ['notify'=>'Product "'.$request->input('name').'" created successfully.','type'=>'success']);
        }else{
            session()->flash('__response', ['notify'=>'Oops something went wrong..','type'=>'error']);
        }
        return redirect()->action('ProductController@getIndex');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug,LaraCart $cart)
    {
        $product = Products::whereSlug($slug)->firstorFail();
        //dd($product);

        // return $product->images->first()->image;
        $product_id = (int)$product->id;
        $find = $cart->find(['id' => $product_id]);
        $quantity = 1;
        if(is_array($find) && count($find)>0){
            $quantity = $find[0]->qty;
        }
        $products = Products::orderBy('id','desc')->where('category_id','=',$product->category_id)->limit(5)->get();
        $product_color = DB::table('product_color')->where('product_id','=',$product->id)->get();
        $product_size = DB::table('product_size')->where('product_id','=',$product->id)->get();
         $product_dimension  = DB::table('product_dimension')->where('product_id','=',$product->id)->get();
        //dd($product_size);
        
        return view('product',compact('product','quantity','product_size','product_color','products','product_dimension'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->breadcrumb['page']  = 'Edit Products';
        $breadcrumb = $this->breadcrumb;
        $product = Products::findOrFail($id);
        $tags = Tags::pluck('name','id');
        $categories = Category::pluck('name','id');
        return view('dashboard.products.edit',compact('product','breadcrumb','tags','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!$request->has('slug')){
            $request->merge(['slug'=>str_slug($request->input('name'))]);
        }
        $product = Products::findOrFail($id);
        //return $request->all();
        $this->validate($request,[
                'name' => 'required',
                'price' => 'required',
                'category_id'=>'required',
                'navs' => 'required',
                'slug' => 'unique:products,slug,'.$product->slug.',slug'
        ],[],[
                'name' => 'title'
        ]);
        $product->fill($request->all());
        $product->save();
        session()->flash('__response', ['notify'=>'Product "'.$product->name.'" updated successfully.','type'=>'success']);
        $product->navs()->sync($request->input('navs'));
        $product->tags()->sync($request->input('tags'));
        if($request->hasFile('photos')) {
            $photos = $request->file('photos');
            foreach ($photos as $photo) {
                if ($photo) {
                   /* $extension = $photo->extension();
                    $filename = md5(str_shuffle(time())) . md5(time()) . '.' . $extension;
                    $path = public_path('assets/images/products/' . $filename);
                    Image::make($photo->getRealPath())->resize(220, 220)->save($path);*/
                    $extension = $photo->getClientOriginalExtension();
                    $filename = md5(str_shuffle(time())).md5(time()).'.'.$extension;
                    $path = public_path('assets/images/products/');
                    $photo->move($path , $filename );

                    $image = ProductImages::create(['product_id' => $product->id, 'image' => $filename]);
                }
            }
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Products::findOrFail($id);
        $name = $product->name;
        foreach($product->images as $image){
            if(file_exists(public_path('assets/images/products/'.$image->image)) && !empty($image->image)){
                unlink(public_path('assets/images/products/'.$image->image));
            }

        }
        $product->delete();
        session()->flash('__response', ['notify'=>'Product "'.$name.'" deleted successfully.','type'=>'success']);
        return back();
    }

    /**
     * Search a product
     *
     * @param  int  $text
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        if($request->input('q')){
            $query = $request->q;
            $products = Products::where('name','like','%'.$query.'%')->orderBy('id','desc')->paginate(10);
            return view('products',compact('products'));
        }
        return redirect()->back();
    }

    public function price_filter(Request $request){
        if($request->has('max') && $request->has('min')){
            $min = (int)$request->input('min');
            $max = (int)$request->input('max');
            $products = Products::whereBetween('price',[$min,$max])->orderBy('id','desc')->paginate(10);

            $products->appends(['min'=>$min,'max'=>$max]);
            return view('products',compact('products'));
        }else{
            return redirect()->action('ProductController@index');
        }
    }

    public function page_products($slug){
        $nav =  SubNavs::whereSlug($slug)->firstOrFail();
        $products = $nav->products()->orderBy('id','desc')->paginate(9);
        return view('products',compact('products'));
    }
}
