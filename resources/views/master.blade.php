@inject('cart', 'LukePOLO\LaraCart\LaraCart')
<?php $cart_items = 0; ?>
@foreach($cart->getItems() as $item)
<?php $cart_items++; ?>
@endforeach
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<html lang="en" class="no-js">
    @include('partials.head')
    @yield('css')
<body>
<!--[if lt IE 9]>
<div class="bg-danger text-center">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/" class="highlight">upgrade your browser</a> to improve your experience.</div>
<![endif]-->

<!--Preloader-->
      <div id="loading">
        <div id="loading-center">
          <div id="loading-center-absolute">
            <div class="object" id="object_one"></div>
            <div class="object" id="object_two"></div>
            <div class="object" id="object_three"></div>
            <div class="object" id="object_four"></div>
          </div>
        </div>
      </div>
<div id="canvas" class="{{ isset($theme['layout']['value']) && $theme['layout']['value']==1?'boxed':'' }} {{ isset($theme['pattern']['value'])?$theme['pattern']['value']:'pattern0' }}">
    <div id="box_wrapper" class="home {{ isset($theme['layout']['value']) && $theme['layout']['value']==1?'container':'' }} {{ isset($theme['margin']['value']) && $theme['margin']['value']==1?'top-bottom-margins':'' }}">
        @include('partials.logo-bar')
        @include('partials.nav')
        @yield('breadcrumb')
        @yield('content')
        @include('partials.footer')
        @include('partials.footer_copy')
    </div>
</div>

<!-- Main libs -->

<script src="{{ asset('assets/js/script.js') }}"></script>

<script>
    $('a.acticecate').on('click', function(){ 
    //tried this by given answer which not worked 
    var category_id = $(this).attr("id"); 
    //alert(category_id) ;
    $('.acticecate').parent().removeClass('active'); 
     $(this).parent().addClass('active'); 
    //ended code 
   
});
	
   function initMap() {
   	var lats=$('#lat').val();
   	var lngs= $('#lng').val();
	
   	var myLatLng = new google.maps.LatLng(lats, lngs);

   	var map = new google.maps.Map(document.getElementById('googleMap'), {
   	zoom: 20,
   	center: myLatLng
   	});

   	var marker = new google.maps.Marker({
   	position: myLatLng,
   	map: map,
   	title: 'Hello World!'
   	});
   }
	   
	  
function paypalcheckout() {
        
        if($('#first_name').val() == ''){
			alert('Please fill in the mandatory fields*');
			return 0;
		}else if($('#last_name').val() == ''){
			alert('Please fill in the mandatory fields*');
			return 0;
		}
		else if($('#address').val() == ''){
			alert('Please fill in the mandatory fields*');
			return 0;
		}
        var formVal = $('form.shop-checkout').serialize();
		console.log(formVal);
        var actionUrl = "{{ url('/pay2')}}";
        $.ajax({
          type: "POST",
          url: actionUrl,
          data: formVal,
          success: function(data){
           
          },
          error: function() {
           
          }
        });
        //return false;
      }
 //preloader
 $(window).load(function() {
     $("#loading").fadeOut(500);
 });
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB1RaWWrKsEf2xeBjiZ5hk1gannqeFxMmw&callback=initMap"></script>
<!-- Notify -->
<script src="{{ asset('assets/plugins/notify.js') }}"></script>
@if(Session::has('__response') && isset(Session::get('__response')['notify']))
    <script>
 
        $(document).ready(function () {
            $.notify('{!! Session::get('__response')['notify'] !!}', "{{Session::get('__response')['type']}}");
        });

    </script>
@endif
@yield('scripts')
</body>

</html>
