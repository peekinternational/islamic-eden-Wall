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
        // $category = Category::first();
        // $category->products;
        // $produt = Products::first();
        // $cat = $produt->category;
        // return $category;
        // dd($category);
        $products = Products::orderBy('id','desc')->paginate(10);
          // dd($products);

         foreach($products as &$rec){
                  $rec->dimension=DB::table('product_dimension')->where('product_id','=',$rec->id)->get()->toArray();
                }
             //dd($products);
         return view('products',compact('products'));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $request)
    {
        $this->breadcrumb['page']  = 'Products List';
        $breadcrumb = $this->breadcrumb;
        if($request->isMethod('post')){
            $id=$request->input('catid');
            $products = Products::where('category_id','=',$id)->orderBy('id','desc')->paginate(9);
         foreach($products as &$rec){
                  $rec->dimension=DB::table('product_dimension')->where('product_id','=',$rec->id)->get()->toArray();
                    $product_color = DB::table('product_color')->where('product_id','=',$rec->id)->get();
        $product_size = DB::table('product_size')->where('product_id','=',$rec->id)->get();
         $product_dimension  = DB::table('product_dimension')->where('product_id','=',$rec->id)->get();
                }
   
            $category=DB::table('categories')->get();
        
        return view('dashboard.products.index',compact('products','breadcrumb','quantity','product_size','product_color','products','product_dimension','category'));
        }
        $products = Products::orderBy('id','desc')->paginate(9);
         foreach($products as &$rec){
                  $rec->dimension=DB::table('product_dimension')->where('product_id','=',$rec->id)->get()->toArray();
				    $product_color = DB::table('product_color')->where('product_id','=',$rec->id)->get();
        $product_size = DB::table('product_size')->where('product_id','=',$rec->id)->get();
         $product_dimension  = DB::table('product_dimension')->where('product_id','=',$rec->id)->get();
                }
   
            $category=DB::table('categories')->get();
        
        return view('dashboard.products.index',compact('products','breadcrumb','quantity','product_size','product_color','product_dimension','category'));
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
   // dd($p_price);
       $dim_offer=$request->input('dim_offer');
       

        $product = Products::create($request->all());
        if($product->id){

            $product->navs()->attach($request->input('navs'));
            if($request->has('tags')){
                $product->tags()->attach($request->input('tags'));
            }
            if($request->hasFile('photos')) {
                $photos = $request->file('photos');
                
                 foreach (array_slice($photos, 0, 6)as $photo) {
                    
                    
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
        // dd($product);

        // return $product->images->first()->image;
        $product_id = (int)$product->id;
        $find = $cart->find(['id' => $product_id]);
        $quantity = 1;
        if(is_array($find) && count($find)>0){
            $quantity = $find[0]->qty;
        }
        $products = Products::orderBy('id','desc')->where('category_id','=',$product->category_id)->limit(5)->get();
         foreach($products as &$rec){
                  $rec->dimension=DB::table('product_dimension')->where('product_id','=',$rec->id)->get()->toArray();
                }
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
        $product_dimension = DB::table('product_dimension')->where('product_id','=',$product->id)->get();
        $product_color = DB::table('product_color')->where('product_id','=',$product->id)->get();
        $product_size = DB::table('product_size')->where('product_id','=',$product->id)->get();

       $images=$product->images->toArray();
       //dd($images[0]['image']);
        // join query

        // $product=DB::table('products')->
        //      join('product_dimension','products.id','=','product_dimension.product_id')->
        //      join('product_color','product_color.product_id','=','products.id')->
        //      join('product_size','product_size.product_id','=','products.id')->
        //      where('products.id','=',$id)->first();
        //      DD($product);

        $tags = Tags::pluck('name','id');
        $categories = Category::pluck('name','id');
        


             

        return view('dashboard.products.edit',compact('images','product','breadcrumb','tags','categories','product_dimension','product_color','product_size'));
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
        // dd($product);
        //return $request->all();
        $this->validate($request,[
                'name' => 'required',
                //'price' => 'required',
                'category_id'=>'required',
                'navs' => 'required',
                'slug' => 'unique:products,slug,'.$product->slug.',slug'
        ],[],[
                'name' => 'title'
        ]);

       $size=$request->input('p_size');
       $p_color=$request->input('color');
      
       $p_dimension=$request->input('p_dimension');
       $p_price=$request->input('p_price');
       //dd($p_price[0]);
       $dim_offer=$request->input('dim_offer');
       

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

        DB::table('product_color')->where('product_id','=',$product->id)->delete();
        foreach($p_color as $color )
            {
                DB::table('product_color')->where('product_id','=',$product->id)->insert(['product_id'=>$product->id,'color'=>$color]);
            }

              if($size){
              foreach($size as $pro_size )
              {
                  $inputs['p_size']=$pro_size;
                  $inputs['product_id']=$product->id;
                  DB::table('product_size')->where('product_id','=',$product->id)->update($inputs);
              }
             }
             DB::table('product_dimension')->where('product_id','=',$product->id)->delete();
              if($dim_offer){
                       DB::table('product_dimension')->where('product_id','=',$product->id)->delete();
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
                               // dd($inputsss);
                               
                                DB::table('product_dimension')->insert($inputsss);
                            }
                        }elseif($p_price[0] !=''){   
                                foreach($p_price as $key=>$price){
                                $inputss['p_price']=$price;
                                $inputss['p_dimension']=$p_dimension[$key];
                                $inputss['product_id']=$product->id;
                                //  DB::table('product_dimension')->where('product_id','=',$product->id)->delete();
                                DB::table('product_dimension')->insert($inputss);
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
     public function copy(Request $request, $id)
    {
         
      $data=DB::table('products')->where('id','=',$id)->first();
    
     $input['category_id']=$data->category_id;
     $input['name']=$data->name;
     $input['slug']=rand().$data->slug;
     $input['price']=$data->price;
     $input['offer']=$data->offer;
     $input['saleprice']=$data->saleprice;
     $input['description']=$data->description;
     $input['Addtional_Information']=$data->Addtional_Information;
     $input['color']=$data->color;
     $input['p_size']=$data->p_size;
     $input['meta_title']=$data->meta_title;
     $input['meta_keywords']=$data->meta_keywords;
     $input['meta_description']=$data->meta_description;

      $product = Products::create($input);
     
      $photos=DB::table('product_images')->where('product_id','=',$id)->get();
       
       foreach ($photos as $photo) {
                if ($photo) {
                    $image = ProductImages::create(['product_id' => $product->id, 'image' => $photo->image]);
                }
            }
     $dymentions = DB::table('product_dimension')->where('product_id','=',$id)->get();
     
     foreach ($dymentions as $dymention) {
                if ($dymention) {
                    DB::table('product_dimension')->insert(['product_id'=>$product->id,'p_dimension'=>$dymention->p_dimension,'p_price'=>$dymention->p_price,'dimoffer_price'=>$dymention->dimoffer_price,'dim_offer'=>$dymention->dim_offer]);
                }
            }
    $p_color = DB::table('product_color')->where('product_id','=',$id)->get();

    foreach($p_color as $color )
        {
            DB::table('product_color')->insert(['product_id'=>$product->id,'color'=>$color->color]);
        }
    $p_tags = DB::table('product_tags')->where('product_id','=',$id)->get();
      foreach($p_tags as $tags )
          {
              DB::table('product_tags')->insert(['product_id'=>$product->id,'tag_id'=>$tags->tag_id]);
          }
      
            
       
}
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

function deleteimg($id){
    //dd($id);
    DB::table('product_images')->where('id','=',$id)->delete();
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
			  foreach($products as &$rec){
                    $rec->dimension=DB::table('product_dimension')->where('product_id','=',$rec->id)->get()->toArray();
				    $product_color = DB::table('product_color')->where('product_id','=',$rec->id)->get();
                    $product_size = DB::table('product_size')->where('product_id','=',$rec->id)->get();
                    $product_dimension  = DB::table('product_dimension')->where('product_id','=',$rec->id)->get();
                }
   
            return view('products',compact('products','product_size','product_color','product_dimension'));
        }
        return redirect()->back();
    }

    public function price_filter(Request $request){
        if($request->has('max') && $request->has('min')){
            $min = (int)$request->input('min');
            $max = (int)$request->input('max');
            $products = Products::whereBetween('price',[$min,$max])->orderBy('id','desc')->paginate(10);
              foreach($products as &$rec){
                    $rec->dimension=DB::table('product_dimension')->where('product_id','=',$rec->id)->get()->toArray();
				    $product_color = DB::table('product_color')->where('product_id','=',$rec->id)->get();
                    $product_size = DB::table('product_size')->where('product_id','=',$rec->id)->get();
                    $product_dimension  = DB::table('product_dimension')->where('product_id','=',$rec->id)->get();
                }
   
            $products->appends(['min'=>$min,'max'=>$max]);
            return view('products',compact('products','product_size','product_color','product_dimension'));
        }else{
            return redirect()->action('ProductController@index');
        }
    }

    public function page_products($slug){
        $nav =  SubNavs::whereSlug($slug)->firstOrFail();
        $products = $nav->products()->orderBy('id','desc')->paginate(9);
        foreach($products as &$rec){
                  $rec->dimension=DB::table('product_dimension')->where('product_id','=',$rec->id)->get()->toArray();
                }
         return view('products',compact('products'));
    }
}
