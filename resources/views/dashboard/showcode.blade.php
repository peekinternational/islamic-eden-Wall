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
	background-color: pink;color: white;display: block;height: 31px;border-radius: 4px;
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
                <h3 class="box-title">Coupon Code</h3>
                <div class="box-tools pull-right">
                  <a href="{{ url('dashboard/addcoupon') }}" type="button" class="btn btn-box-tool"  data-toggle="tooltip" title="New coupon">
                        <i class="fa fa-plus"></i>
                    </a>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                @include('dashboard.partials.formErrorMessage')
                <table class="table table-bordered">
                    <tbody><tr>
                        <th>Coupon Code</th>
                        <th>Discount Type</th>
                        <th>Discount Price</th>
                        <th>Expiry Date</th>
						<th>Status </th>
                        <th>Action</th>
                    </tr>
                    @foreach($coupon as $order)
                   
                        <tr>
                            <td>{{ $order->code }}</td>
                            <td>{{ $order->type }}</td>
							 <td>{{ $order->discount }}</td>
                            <td>{{ $order->expiry_date }}</td>
							<td>
							<?php if(date("Y-m-d") > $order->expiry_date ){
								echo '<span class="label label-danger">Expire</span>';
							}
							else{
								echo '<span class="label label-success">Active</span>';
							}
							
							?>
							</td>
                            <td><span class="btn-edit">

                                    <a href="{{ url('dashboard/editcoupon/'.$order->id) }}" class="btn btn-xs btn-warning" data-toggle="tooltip"  data-original-title="Edit"><i class="fa fa-edit"></i> </a>

                                    {!! Form::open(['action'=>['SettingsController@destroy',$order->id],'method'=>'delete','style'=>'display:inline;']) !!}
                                   <input type="hidden" class="delete_permanent" name="delete_permanent" value="0">
                                    <button type="submit" class="btn btn-xs btn-danger btn-delete-user" data-toggle="tooltip"  data-original-title="Delete"><i class="fa fa-trash-o"></i></button>
                                    {!! Form::close() !!}
                            </span></td>
                            
                        </tr>
                    @endforeach
                    @if($coupon->isEmpty())
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
               {{ $coupon->links() }}
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
