<?php

namespace Edenmill\Http\Controllers;

use Edenmill\Category;
use Edenmill\Products;
use Edenmill\ShopCategories;
use Edenmill\SubNavs;
use Illuminate\Http\Request;

use Edenmill\Http\Requests;
use Illuminate\Support\Facades\View;
use DB;

class CategoryController extends Controller
{
        protected $breadcrumb = array(
                'title'        => 'Product Categories',
                'description'  => 'Manage product categories.',
                'page'         => ''
        );
       public function index(){
                $this->breadcrumb['page'] = 'Show Categories';
                $breadcrumb = $this->breadcrumb;
               $categories = Category::all();
               return view('dashboard.category.index',compact('breadcrumb','categories'));
       }
       public function show($slug){
                $categories = Category::pluck('name','id');
                $id = null;
                foreach($categories as $cat_id=>$category){
                        if(str_slug($category)===trim($slug)){
                                $id = $cat_id;
                                break;
                        }
                }

        $products = Products::orderBy('id','desc')->where('category_id','=',$id)->get();
         foreach($products as &$rec){
                  $rec->dimension=DB::table('product_dimension')->where('product_id','=',$rec->id)->get()->toArray();
                }
        $product_color = DB::table('product_color')->where('product_id','=',$products->id)->get();
        $product_size = DB::table('product_size')->where('product_id','=',$products->id)->get();
         $product_dimension  = DB::table('product_dimension')->where('product_id','=',$products->id)->get();

               return view('products',compact('category','products','quantity','product_size','product_color','products','product_dimension'));
       }

        public function edit($id){
                $category = Category::findOrFail($id);
                return view('dashboard.category.edit',compact('category'));
        }
        public function store(Request $request){
                $this->validate($request,[
                        'name' => 'required|unique:categories',
                ]);
                Category::create($request->all());
                session()->flash('__response', ['notify' => 'Category "' . $request->input('name') . '" created successfully.', 'type' => 'success']);
                return redirect()->action('CategoryController@index');
        }
        public function create(){
                return view('dashboard.category.create');
        }
        public function update($id,Request $request){
                $category = Category::findOrFail($id);
                $this->validate($request,[
                        'name' => 'required|unique:categories,name,'.$category->id,
                ]);
                $category->fill($request->all());
                $category->save();
                session()->flash('__response', ['notify' => 'Category "' . $request->input('name') . '" updated successfully.', 'type' => 'success']);
                return back();
        }
       public function destroy($id){
               $category = Category::findOrFail($id);
               $category->delete();
               session()->flash('__response', ['notify' => 'Deleted "' . $category->name . '" deleted successfully.', 'type' => 'success']);
               return back();
       }
}
