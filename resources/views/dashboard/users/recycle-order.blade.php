@extends('dashboard.layouts.default')
@section('css')
<style>
.received{
	background-color: green;color: white;display: block;height: 31px;border-radius: 4px;
}
.process{
	background-color: green;color: white;display: block;height: 31px;border-radius: 4px;
}
.shipped{
	background-color: orange;color: white;display: block;height: 31px;border-radius: 4px;
}
.deliver{
	background-color: red;color: white;display: block;height: 31px;border-radius: 4px;
}
.green{
	height: 18px;width: 18px; background-color: green;border-radius: 50%;display: inline-block;margin-left: 19px;
}
.red{
	height: 18px;width: 18px; background-color: red;border-radius: 50%;display: inline-block;margin-left: 19px;
}
.yellow{
	height: 18px;width: 18px; background-color: yellow;border-radius: 50%;display: inline-block;margin-left: 19px;
}
</style>
@stop
@section('content')
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Orders</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                @include('dashboard.partials.formErrorMessage')
                <table class="table table-bordered">
                    <tbody><tr>
                        <th>Payer ID</th>
                        <th>Name</th>
                        <th>Cart Items</th>
                        <th>Total Price</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>Country</th>
                        <th>IPN Track id</th>
                        <th>Payment Status</th>
                        <th>Delivery Status</th>
                        <th>Payment Date</th>
                        <th>Action</th>

                    </tr>
                    @foreach($orders as $order)
                    <?php 
					$Date = date("Y-m-d");
					$date1=date_create($Date);
                    $date2=date_create($order->delivery_days);
					$diff=date_diff($date1,$date2, false);
					
					
                        //$products =  $order->products($order->id)->get();
                        $order_products = $order->order_products()->select('order_products.*','products.name',DB::raw('((order_products.quantity * order_products.price) + IFNULL(order_products.tax, 0)) as total'),DB::raw('((order_products.quantity * order_products.price) + IFNULL(order_products.tax, 0)) as total'))->join('products', 'products.id', '=', 'order_products.product_id')->get();
                     ?>
                        <tr>
                            <td>{{ $order->payer_id }}</td>
                            <td>{{ $order->address_name }}</td>
                            <td>
                            {{ $order->num_cart_items }} 
                            <span data-toggle="tooltip" title="Show details"></span>
                            <button type="button" data-toggle="modal" data-target="#modal-id-{{ $order->id }}"  class="btn btn-xs btn-primary pull-right"><i class="fa fa-eye"></i></button>
                            
                            <div class="modal fade" id="modal-id-{{ $order->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title">Order Details</h4>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Quantity</th>
                                                    <th>Price</th>
													<th>Size</th>
													<th>Color</th>
                                                    <th>Tax</th>
                                                    <th>SubTotal</th>
                                                </tr>
                                                @foreach($order_products as $_product)
                                                    <tr>
                                                        <td>
                                                        {{ $_product->name }}
                                                        </th>
                                                        <td>{{ $_product->quantity }}</th>
                                                        <td>&euro; {{ $_product->price }}</th>
														<td>{{ $_product->p_size }}</th>
														<td>{{ $_product->color }}</th>
                                                        <td>&euro; {{ (float)$_product->tax }}</th>
                                                        <td>&euro; {{ ($_product->quantity * $_product->price) + (float)$_product->tax }}</th>
                                                    </tr>
                                                    @endforeach
                                                     <tr >
												   
                                                        <th colspan="6" style="border-top:2px solid black">Total</th>
                                                        <th style="border-top:2px solid black">&euro; {{ $order_products->sum('total') }}</th>
                                                    </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </td>
                            <td>&euro; {{ $order_products->sum('total') }}</td>
                            <td>{{ $order->payer_email }}</td>
                            <td>{{ $order->address_city }}</td>
							 <td>{{ $order->city }}</td>
                            <td>{{ $order->address_country_code }}</td>
                            <td>{{ $order->ipn_track_id }}</td>
							@if($order->payment_status == 'Paid')
                            <td>
                                <label class="label label-success">Paid</label>
                            </td>
							@else
								 <td>
                                <label class="label label-warning">Unpaid</label>
                            </td>
							@endif
                            <td>
							
							@if($order->delivery_status =='received')
							@if($diff->format("%R%a days") >= +0  && $diff->format("%R%a days") < +6)
							 <span data-toggle="tooltip" title="{{$order->delivery_status}}!" id="colors{{ $order->id }}" style="" class="form-group yellow"></span>
						     @elseif($diff->format("%R%a days") < +0)
							 <span data-toggle="tooltip" title="{{$order->delivery_status}}!" id="colorss{{ $order->id }}" style="" class="form-group red"></span>
							 @else
								 <span data-toggle="tooltip" title="{{$order->delivery_status}}!" id="color{{ $order->id }}" style="" class="form-group green"></span>
							 @endif
						       <select class="received status{{ $order->id }}" style=""  onchange="changestatus('{{ $order->id }}')">
							   <option value="">{{ucfirst($order->delivery_status)}}</option>
							   <option value="process">Process</option>
							   <option value="shipped">Shipped</option>
							   <option value="deliver">Deliver</option>
							   </select>
							
							@elseif($order->delivery_status =='process')
							@if($diff->format("%R%a days") >= +0  && $diff->format("%R%a days") < +6)
							 <span data-toggle="tooltip" title="{{$order->delivery_status}}!" id="colors{{ $order->id }}" style="" class="form-group yellow"></span>
						     @elseif($diff->format("%R%a days") < +0)
							 <span data-toggle="tooltip" title="{{$order->delivery_status}}!" id="colorss{{ $order->id }}" style="" class="form-group red"></span>
							 @else
								 <span data-toggle="tooltip" title="{{$order->delivery_status}}!" id="color{{ $order->id }}" style="" class="form-group green"></span>
							 @endif
							<select class="process status{{ $order->id }}" style=""  onchange="changestatus('{{ $order->id }}')">
							  <option value="">{{ucfirst($order->delivery_status)}}</option>
							 <option value="received">Received</option>
							 <option value="shipped">Shipped</option>
							  <option value="deliver">Deliver</option>
							</select>
							
                                @elseif($order->delivery_status =='shipped')
							<span data-toggle="tooltip" title="{{$order->delivery_status}}!" style="display:none" id="color{{ $order->id }}" class="green"></span>
							<select class="shipped status{{ $order->id }}" style=""  onchange="changestatus('{{ $order->id }}')">
							  <option value="">{{ucfirst($order->delivery_status)}}</option>
							  <option value="received">Received</option>
							  <option value="process">Process</option>
							  <option value="deliver">Deliver</option>
							</select>
							
                                @elseif($order->delivery_status =='deliver')
								  <span data-toggle="tooltip" title="{{$order->delivery_status}}!" style="display:none" id="color{{ $order->id }}" class="green"></span>
								  <select class="deliver status{{ $order->id }}" style=""  onchange="changestatus('{{ $order->id }}')">
								  <option value="">{{ucfirst($order->delivery_status)}}</option>
								  <option value="received">Received</option>
								  <option value="process">Process</option>
								  <option value="shipped">Shipped</option>
								  </select>
							
                               @endif 
                            </td>
							
                            <td>{{ $order->payment_date }}</td>
                            <td><span class="btn-edit">
                                    {!! Form::open(['action'=>['RecycleController@destroy',$order->id],'method'=>'delete','class'=>'remove-orderr','style'=>'display:inline;']) !!}
                                   <input type="hidden" class="delete_permanent" name="delete_permanent" value="0">
                                    <a href="javascript:void(0);" class="btn btn-xs btn-danger btn-delete-user removeRecord" data-toggle="tooltip" onclick="remove_records({{$order->id}})"  data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
                                    {!! Form::close() !!}
                            </span></td>
                        </tr>
                    @endforeach
                    @if($orders->isEmpty())
                        <tr>
                            <td colspan="13">
                                <p class="alert alert-warning text-center">
                                    No orders found.
                                </p>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
               {{ $orders->links() }}
            </div>
            <!-- /.box-footer-->
        </div>
        <!-- /.box -->
		<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
    </section>
@stop
@section('footer')
    <script>

$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip(); 
});
   function remove_records(payer_id) {
   // event.preventDefault();
    if (confirm('Are you sure want to delete this menu')) {
            $('.remove-orderr').submit();
    }
   else
   {
      
   }       
   event.preventDefault();
   

function changestatus(id){
	var val=$('.status'+id).val();
	 
        var actionUrl = "{{ url('dashboard/changestatus')}}/"+id+'?delivery_status='+val;
        $.ajax({
          type: "get",
          url: actionUrl,
          success: function(data){
			  var start = new Date(data[0].delivery_days);
              var end  = new Date();
			  days = (start - end) / (1000 * 60 * 60 * 24);
              var getday = Math.round(days);
			 if(data[0].delivery_status == 'received'){
				 if(getday >= 0 && getday < 6){
				 $("#color"+id).hide();
				 $("#colors"+id).show();
				 $("#colorss"+id).hide();
				 }
				 else if(getday < 0){
				 $("#color"+id).hide();
				 $("#colors"+id).hide();
				 $("#colorss"+id).show();
				 }
				 else{
					 $("#color"+id).show();
				 }
				 
				 $("#color"+id).addClass("green");
				 $(".status"+id).addClass("received");
				 $(".status"+id).removeClass("process");
				  $(".status"+id).removeClass("shipped");
				   $(".status"+id).removeClass("deliver");
				 
			 }
			 else if(data[0].delivery_status == 'process'){
				  if(getday >= 0 && getday < 6){
				 $("#color"+id).hide();
				 $("#colors"+id).show();
				 $("#colorss"+id).hide();
				 }
				 else if(getday < 0){
				 $("#color"+id).hide();
				 $("#colors"+id).hide();
				 $("#colorss"+id).show();
				 }
				 else{
					 $("#color"+id).show();
				 }
				 $("#color"+id).addClass("green");
				 $(".status"+id).addClass("process");
				 $(".status"+id).removeClass("received");
				 $(".status"+id).removeClass("shipped");
				 $(".status"+id).removeClass("deliver");
			 }
			  else if(data[0].delivery_status == 'shipped'){
				  $("#color"+id).hide();
				 $("#colors"+id).hide();
				 $("#colorss"+id).hide();
				 $(".status"+id).addClass("shipped");
				 $(".status"+id).removeClass("process");
				 $(".status"+id).removeClass("received");
				 $(".status"+id).removeClass("deliver");
			 }
			  else if(data[0].delivery_status == 'deliver'){
				 $("#color"+id).hide();
				 $("#colors"+id).hide();
				 $("#colorss"+id).hide();
				 $(".status"+id).addClass("deliver");
				 $(".status"+id).removeClass("process");
				 $(".status"+id).removeClass("shipped");
				 $(".status"+id).removeClass("received");
			 }
			 
           
          },
          error: function() {
            
          }
        });
	
}
</script>
@stop
