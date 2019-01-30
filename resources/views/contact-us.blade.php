@extends('master')
@section('title', 'Home Page')
@section('breadcrumb')
    @include('partials/breadcrumb')
@stop
@section('content')


<div class="container">
	<div class="row responsive-cont" style="padding-top:40px">
		  <div class="col-md-12">
             <h3  class="title-featured text-left" style="    margin-bottom: 20px;"> <span>CONTACT US</span>
             </h3>
             <hr>
			  <div class="panel">
					<div class="panel-heading contact-panel">
						<h3 style="padding-top:10px"><i class="fa fa-map-marker" aria-hidden="true"></i> Location</h3>
					</div>
					<input type="hidden" id="lat" value="{{$map_lats->value}}" >
					<input type="hidden" id="lng" value="{{$map_lngs->value}}" >
					<div class="panel-body">
			 		<div id="googleMap" style="width:100%;height:400px;"></div>
					 </div>
			    </div>
		    </div>
	    </div>
<hr>
<div class="row responsive-cont" style="padding-top:25px">
			<div class="col-sm-4 col-lg-4 col-padding">
				<div class="panel">
					<div class="panel-heading contact-panel">
						<h3><i class="fa fa-thumb-tack" aria-hidden="true"></i>Information
					</div>
					<div class="panel-body">
						<address>
						<strong class="fa fa-map-marker">&nbsp;&nbsp;{{$address->value}}</strong><br>
						<strong class="fa fa-envelope">&nbsp;{{$email->value}}</strong><br>
						<strong class="fa fa-clock-o">&nbsp;{{$working_hours->value}}</strong><br>

						
						<i  class="fa fa-phone"></i>&nbsp; {{$phone_num->value}}
						</address>
					</div>
				</div>
			
			</div>
       <div class="col-12 col-lg-8 col-padding">
	  			<div class="panel">
						<div class="panel-heading contact-panel">
							<h3 class="">
							<i class="fa fa-envelope" aria-hidden="true"></i>

							 contact us
							</h3>
						</div>
					<div class="panel-body contct-body">
						<form class="remove-order" method="post" name="contac_form" action="{{ url('conatctus')}}">
								  {!! csrf_field() !!}
						<div class="form-group">
								<input type="text" class="form-control" id="" name="name" placeholder="Name">
								<span class="help-block" style="display: none;"> enter your name.</span>
						  </div>
						  <div class="form-group">
								<input type="email" class="form-control" id="" name="email" placeholder="Email Address">
								<span class="help-block" style="display: none;"> enter a valid e-mail address.</span>
						  </div>
						  <div class="form-group">
								<textarea rows="4" cols="100" class="form-control" id="" name="message" placeholder="Message"></textarea>
								<span class="help-block" style="display: none;"> enter a message.</span>
						  </div>
						  <button type="submit" id="feedbackSubmit" name="feedbackSubmit" class="btn btn-primary btn-lg" style="display: block; margin-top: 10px;">Contact US</button>
						</form>
					<!-- END CONTACT FORM -->
					</div>
				</div>
		  </div>
      </div>
</div>

@stop
@section('script')
    <script>

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB1RaWWrKsEf2xeBjiZ5hk1gannqeFxMmw&callback=initMap"></script>



@stop