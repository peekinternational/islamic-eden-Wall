<?php

namespace Edenmill\Http\Controllers;

use Edenmill\Orders;
use Illuminate\Http\Request;

use Edenmill\Http\Requests;
use DB;
use Mail;
class RecycleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       //DB::enableQueryLog();
        Orders::whereRead(0)->update(['read'=>1]);
        $orders = Orders::where('status','=','Inactive')->orderBy('id','desc')->paginate(20);
        
         // print_r(DB::getQueryLog());die();
        //return $order_products->sum('total');
        return view('dashboard.recycleorder',compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
	
	 public function updatestatus(Request $request, $id)
    {
       // dd($request->all());
		$return=DB::table('orders')->where('id','=',$id)->update($request->all());
		if($return== 1){
			$data= DB::table('orders')->where('id','=',$id)->get();
			 $pro= DB::table('order_products')->join('products', 'order_products.product_id', '=', 'products.id')->select('order_products.*', 'products.name')->where('order_products.order_id','=',$id)->get();
			  $sum= DB::table('order_products')->join('products', 'order_products.product_id', '=', 'products.id')->select('order_products.*', 'products.name')->where('order_products.order_id','=',$id)->sum('order_products.price');
			// dd($pro);
			$email['email'] = $data[0]->payer_email;
            $toemail =$email['email'];
			 Mail::send('emails.order_status',['order' =>$data[0],'product' =>$pro,'total'=>$sum,'status'=>$data[0]->delivery_status],
                        function ($message) use ($toemail)
                        {
                            $message->subject('Islamic Wall - Order Status');
                            $message->from('nabeelirbab@gmail.com', 'Islamic Wall');
                            $message->to($toemail);
                         });
		return $data;
		}
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
    {
        $product = DB::table('orders')->where('id',$id)->delete();
       
        session()->flash('__response', ['notify'=>' Delete order.','type'=>'success']);
        return back();
    }
}
