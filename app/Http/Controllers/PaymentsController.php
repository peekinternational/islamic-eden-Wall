<?php

namespace Edenmill\Http\Controllers;

use Anouar\Paypalpayment\PaypalPayment;
use Edenmill\OrderProducts;
use Edenmill\Products;
use Illuminate\Http\Request;

use Edenmill\Http\Requests;

use Edenmill\Orders;
use Illuminate\Support\Facades\Mail;
use Edenmill\Mail\AdminOrderCompleted;
use Edenmill\Mail\UserOrderCompleted;
use Edenmill\User;
use Edenmill\GiftOrders;
use LukePOLO\LaraCart\Facades\LaraCart;

use DB;
use Session;
class PaymentsController extends Controller
{
	
	
	/**
	* object to authenticate the call.
	     * @param object $_apiContext
	     */
	    private $_apiContext;
	
	
	/**
	* Set the ClientId and the ClientSecret.
	     * @param
	     *string $_ClientId
	     *string $_ClientSecret
	     */
	    private $_ClientId = 'AdZUQndq3waQ-PhvNBAxMLpmji6zCUhHXqqQGE16U4z9mBXxZw9H-71qyrEEDe6ZQe0On26CbnOWxg7J';
	private $_ClientSecret='EHVAEcXgWp3ihDEiJcOKrgHueQcxujoOnnH2o8W0v7sjKe7HSoMKWz_M56LNt4_BOu0TJEa5FkvT0EcZ';
	
	
	/*
	*   These construct set the SDK configuration dynamiclly,
	     *   If you want to pick your configuration from the sdk_config.ini file
	     *   make sure to update you configuration there then grape the credentials using this code :
	     *   $this->_cred= Paypalpayment::OAuthTokenCredential();
	*/
	    public function __construct()
	    {
		
		// 		### Api Context
		        // 		Pass in a `ApiContext` object to authenticate
		        // 		the call. You can also send a unique request id
		        // 		(that ensures idempotency). The SDK generates
		        // 		a request id if you do not pass one explicitly.
		        $payment = new PaypalPayment();
		
		$this->_apiContext = $payment->ApiContext($this->_ClientId, $this->_ClientSecret);
		
		// 		Uncomment this step if you want to use per request
		        // 		dynamic configuration instead of using sdk_config.ini
		
		$this->_apiContext->setConfig(array(
		                'mode' => 'sandbox',
		                'service.EndPoint' => 'https://api.sandbox.paypal.com',
		                'http.ConnectionTimeOut' => 30,
		                'log.LogEnabled' => true,
		                'log.FileName' => __DIR__.'/../PayPal.log',
		                'log.LogLevel' => 'FINE'
		        ));
	}
	
	public function payGift(Request $request){
      
       if(isset($_GET['_token'])){
           $request->merge($_GET);
			$orderCount =  GiftOrders::where('_token','=',$request->input('_token'))->count();
			if(!$orderCount>0){
                $_request = $request->all();
                $order =  GiftOrders::create($_request);
                if(isset($order->id)){
                    $email = $request->input('payer_email');
                    Mail::to($email)->send(new UserOrderCompleted($_request));
                    $users = User::all();
                    foreach($users as $user){
                        if($user->hasRole('admin')){
                            Mail::to($user->email)->send(new AdminOrderCompleted($_request));
                        }
                    }
                    return 'true';
                }    
            }
        }
		
		return 'false';
	}
	public function pay2(Request $request,LaraCart $cart){
		
		//dd($request->all());
		$Date = date("Y-m-d");
        $delivery_days = date('Y-m-d', strtotime($Date. ' + 20 days'));
		
		$input['user_id']=$request->input('custom');
	    $input['_token']=$request->input('_token');
		$input['payer_id']='none';
		$input['payment_date']='none';
		$input['payment_status']='Pending';
		$input['payer_status']='unverfied';
		$input['business']=$request->input('email');
		$input['ipn_track_id']='none';
		$input['num_cart_items']=$request->input('num_cart_items');
		$input['address_name']=$request->input('first_name');
		$input['address_city']=$request->input('address1');
		$input['address_street']=$request->input('address2');
		$input['city']=$request->input('city');
		$input['delivery_status']='received';
		$input['delivery_days']=$delivery_days;
		$input['address_zip']=$request->input('zip');
		$input['payer_email']=$request->input('email');
		$input['address_country_code']=$request->input('country');
		$input['mobilenumber']=$request->input('night_phone_a');
		$email=$request->input('email');
		$request->session()->put('buy_email',$email);
		//$request->session()->put('key', 'value');
		
		if($request->input('_token') != null){
         
			$orderCount =  Orders::where('user_id','=',$request->input('custom'))->count();
			if(!$orderCount>0){
                $_request = $request->all();
				$order =  DB::table('orders')->insertGetId($input);
				if(isset($order)){
					for ($i=1;$i<=$request->input('total');$i++){
						
							$product = Products::find($request->input('p_id'.$i));
								if($product->id){
									$dd=OrderProducts::create([
															'order_id' => $order,
															'product_id' => $product->id,
															'price' => $request->input('price_'.$i),
															'quantity' => $request->input('quantity_'.$i),
															'p_size' => $request->input('p_size'.$i),
															'color' => $request->input('color_'.$i),
															'tax' => 'tax',
								
								]);
							
							
						}
						
					}
                   
					return 'true';
				}
			}
		}
		return 'false';
	}
	public function pay(Request $request){
		//dd($request->session()->get('buy_email'));
			$_request= $request->all();
		
			$inputs['payer_id']=$request->input('payer_id');
			$inputs['payment_date']=$request->input('payment_date');
			$inputs['payment_status']='Paid';
			$inputs['payer_status']=$request->input('payer_status');
			$inputs['payer_email']=$request->input('payer_email');
			$inputs['business']=$request->input('business');
			$inputs['ipn_track_id']=$request->input('ipn_track_id');
			$inputs['num_cart_items']=$request->input('num_cart_items');
			$orderCount =  DB::table('orders')->where('user_id','=',$request->input('custom'))->update($inputs);
			if($orderCount){
			        	//$email['email'] = 'toseef3@gmail.com';
                        $toemail =$inputs['payer_email'];
			            Mail::send('emails.order_complete',['order' =>$inputs],
                        function ($message) use ($toemail)
                        {
                            $message->subject('Islamic Wall - Order Received');
                            $message->from('nabeelirbab@gmail.com', 'Islamic Wall Design');
                            $message->to($toemail);
                         });
                    //$email = $request->session()->get('buy_email');
					
					return 'true';
				
			}
		
		return 'false';
	}
	
		public function thanks(Request $request){
		if(isset($_GET['clear_cart']) && $_GET['clear_cart']=='true'){
			 LaraCart::destroyCart();
			 
			 $request->session()->forget('coupon');
			 $request->session()->forget('buy_email');
		}
		return view('thanks');
	}
	
	
	/**
	* Display a listing of the resource.
	     *
	     * @return \Illuminate\Http\Response
	     */
	    public function index(PaypalPayment $payment)
	    {
		
		echo "<pre>";
		
		$payments = $payment->getAll(array('count' => 10, 'start_index' => 0), $this->_apiContext);
		
		dd($payments);
		
		$addr= $payment->address();
		$addr->setLine1("3909 Witmer Road");
		$addr->setLine2("Niagara Falls");
		$addr->setCity("Niagara Falls");
		$addr->setState("NY");
		$addr->setPostalCode("14305");
		$addr->setCountryCode("US");
		$addr->setPhone("716-298-1822");
		
		// 		### CreditCard
		        $card = $payment->creditCard();
		$card->setType("visa")
		                ->setNumber("4758411877817150")
		                ->setExpireMonth("05")
		                ->setExpireYear("2019")
		                ->setCvv2("456")
		                ->setFirstName("Joe")
		                ->setLastName("Shopper");
		
		// 		### FundingInstrument
		        // 		A resource representing a Payer's funding instrument.
        // Use a Payer ID (A unique identifier of the payer generated
        // and provided by the facilitator. This is required when
        // creating or using a tokenized funding instrument)
        // and the `CreditCardDetails`
        $fi = $payment->fundingInstrument();
        $fi->setCreditCard($card);
        // ### Payer
        // A resource representing a Payer that funds a payment
        // Use the List of `FundingInstrument` and the Payment Method
        // as 'credit_card'
        $payer = $payment->payer();
        $payer->setPaymentMethod("credit_card")
                ->setFundingInstruments(array($fi));
        $item1 =$payment->item();
        $item1->setName('Ground Coffee 40 oz')
                ->setDescription('Ground Coffee 40 oz')
                ->setCurrency('USD')
                ->setQuantity(1)
                ->setTax(0.3)
                ->setPrice(7.50);
        $item2 = $payment->item();
        $item2->setName('Granola bars')
                ->setDescription('Granola Bars with Peanuts')
                ->setCurrency('USD')
                ->setQuantity(5)
                ->setTax(0.2)
                ->setPrice(2);
        $itemList = $payment->itemList();
        $itemList->setItems(array($item1,$item2));
        $details = $payment->details();
        $details->setShipping("1.2")
                ->setTax("1.3")
                //total of items prices
                ->setSubtotal("17.5");
        //Payment Amount
        $amount = $payment->amount();
        $amount->setCurrency("USD")
                // the total is $17.8 = (16 + 0.6) * 1 ( of quantity) + 1.2 ( of Shipping).
                ->setTotal("20")
                ->setDetails($details);
        // ### Transaction
        // A transaction defines the contract of a
        // payment - what is the payment for and who
        // is fulfilling it. Transaction is created with
        // a `Payee` and `Amount` types
        $transaction = $payment->transaction();
        $transaction->setAmount($amount)
                ->setItemList($itemList)
                ->setDescription("Payment description")
                ->setInvoiceNumber(uniqid());
        // ### Payment
        // A Payment Resource; create one using
        // the above types and intent as 'sale'
        $pay = $payment->payment();
        $pay->setIntent("sale")
                ->setPayer($payer)
                ->setTransactions(array($transaction));
        try {
            // ### Create Payment
            // Create a payment by posting to the APIService
            // using a valid ApiContext
            // The return object contains the status;
            $pay->create($this->_apiContext);
        } catch (\PPConnectionException $ex) {
            return  "Exception: " . $ex->getMessage() . PHP_EOL;
            exit(1);
        }
        dd($pay);
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
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
        //
    }
}
