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
					<div class="panel-body">
			 		<iframe width="100%" height="450" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q={{$map_lats->value}},{{$map_lats->value}}&amp;key=AIzaSyAiWuG1UEcfnqtUhgWz-66bJLZMkx-Avi8"></iframe>
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
						<strong>{{$address->value}}</strong><br>
						<strong>{{$email->value}}</strong><br>
						<strong>{{$working_hours->value}}</strong><br>

						
						<i class="icon-phone-sign"></i> {{$phone_num->value}}
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
						<form method="post" action="">

						<div class="form-group">
								<input type="text" class="form-control" id="" name="" placeholder="Name">
								<span class="help-block" style="display: none;"> enter your name.</span>
						  </div>
						  <div class="form-group">
								<input type="email" class="form-control" id="" name="" placeholder="Email Address">
								<span class="help-block" style="display: none;"> enter a valid e-mail address.</span>
						  </div>
						  <div class="form-group">
								<textarea rows="4" cols="100" class="form-control" id="" name="" placeholder="Message"></textarea>
								<span class="help-block" style="display: none;"> enter a message.</span>
						  </div>
						  <button type="submit" id="feedbackSubmit" class="btn btn-primary btn-lg" style="display: block; margin-top: 10px;">Send Feedback</button>
						</form>
					<!-- END CONTACT FORM -->
					</div>
				</div>
		  </div>
      </div>
</div>
@if(!isset($theme['hide-home-map']['value']) || $theme['hide-home-map']['value'] == 1)
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB1RaWWrKsEf2xeBjiZ5hk1gannqeFxMmw"></script>
<script type="text/javascript">
    var lat;
    var lng;
    var map;
    var styles = [
        {
            "featureType": "landscape.man_made",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "{{ (isset($map['man-made-color']['value']) && !empty($map['man-made-color']['value']) && strlen(trim($map['man-made-color']['value'])) == 7)?trim($map['man-made-color']['value']):'#f7f1df' }}"
                }]
        },
        {
            "featureType": "landscape.natural",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#d0e3b4"
                }]
        },
        {
            "featureType": "landscape.natural.terrain",
            "elementType": "geometry",
            "stylers": [
                {
                    "visibility": "off"
                }]
        },
        {
            "featureType": "poi",
            "elementType": "labels",
            "stylers": [
                {
                    "visibility": "off"
                }]
        },
        {
            "featureType": "poi.business",
            "elementType": "all",
            "stylers": [
                {
                    "visibility": "off"
                }]
        },
        {
            "featureType": "poi.medical",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#fbd3da"
                }]
        },
        {
            "featureType": "poi.park",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "{{ (isset($map['park-color']['value']) && !empty($map['park-color']['value']) && strlen(trim($map['park-color']['value'])) == 7)?trim($map['park-color']['value']):'#bde6ab' }}"
                }]
        },
        {
            "featureType": "road",
            "elementType": "geometry.stroke",
            "stylers": [
                {
                    "visibility": "off"
                }]
        },
        {
            "featureType": "road",
            "elementType": "labels",
            "stylers": [
                {
                    "visibility": "off"
                }]
        },
        {
            "featureType": "road.highway",
            "elementType": "geometry.fill",
            "stylers": [
                {
                    "color": "#ffe15f"
                }]
        },
        {
            "featureType": "road.highway",
            "elementType": "geometry.stroke",
            "stylers": [
                {
                    "color": "{{ (isset($map['highway-color']['value']) && !empty($map['highway-color']['value']) && strlen(trim($map['highway-color']['value'])) == 7)?trim($map['highway-color']['value']):'#ffe15f' }}"
                }]
        },
        {
            "featureType": "road.arterial",
            "elementType": "geometry.fill",
            "stylers": [
                {
                    "color": "{{ (isset($map['road-color']['value']) && !empty($map['road-color']['value']) && strlen(trim($map['road-color']['value'])) == 7)?trim($map['road-color']['value']):'#ffffff' }}"
                }]
        },
        {
            "featureType": "road.local",
            "elementType": "geometry.fill",
            "stylers": [
                {
                    "color": "black"
                }]
        },
        {
            "featureType": "transit.station.airport",
            "elementType": "geometry.fill",
            "stylers": [
                {
                    "color": "#cfb2db"
                }]
        },
        {
            "featureType": "water",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "{{ (isset($map['water-color']['value']) && !empty($map['water-color']['value']) && strlen(trim($map['water-color']['value'])) == 7)?trim($map['water-color']['value']):'#a2daf2' }}"
                }]
        }];
    <?php
		    // print_r($map_lat);
		    // die;
        $map_lat = $map_lats->value;
		$map_lng = $map_lngs->value;

        if(isset($map['lat']['value']) && !empty($map['lat']['value'])){
            $map_lat = $map['lat']['value'];
        }
        if(isset($map['lng']['value']) && !empty($map['lng']['value'])){
            $map_lng = $map['lng']['value'];
        }
    ?>
    jQuery.getJSON('http://maps.googleapis.com/maps/api/geocode/json?latlng={{ $map_lat }},{{ $map_lng }}', function (data)
    {
        lat = data.results[0].geometry.location.lat;
        lng = data.results[0].geometry.location.lng;
    }).complete(function ()
    {
        dxmapLoadMap();
    });
    function attachSecretMessage(marker, message)
    {
        var infowindow = new google.maps.InfoWindow(
                {
                    content: message
                });
        google.maps.event.addListener(marker, 'click', function ()
        {
            infowindow.open(map, marker);
        });
    }
    window.dxmapLoadMap = function ()
    {
        var center = new google.maps.LatLng(lat, lng);
        var settings = {
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            zoom: {{ (isset($map['zoom']['value']) && !empty($map['zoom']['value'])?$map['zoom']['value']:15)  }},
            draggable: {{ (isset($map['scrollwheel']['value']) && !empty($map['scrollwheel']['value'])?$map['scrollwheel']['value']:'false')  }},
            scrollwheel: {{ (isset($map['scrollwheel']['value']) && !empty($map['scrollwheel']['value'])?$map['scrollwheel']['value']:'false')  }},
            center: center,
            styles: styles
        };
        map = new google.maps.Map(document.getElementById('map'), settings);
        var image = '{{ asset('assets/images/settings/'.(isset($map['marker']['value']) && !empty($map['marker']['value'])?$map['marker']['value']:'google_marker.png')) }}';
        var marker = new google.maps.Marker(
                {
                    position: center,
                    title: '{{ (isset($map['title']['value']) && !empty($map['title']['value'])?$map['title']['value']:'Map Title')  }}',
                    map: map,
                    icon: image
                });
        marker.setTitle('Map title'.toString());
        //type your map title and description here
        attachSecretMessage(marker, '<h3>Map title</h3><p>Map HTML description</p>');
    
</script>
    <script>
      var map;
      function initMap() {
        var myLatLng = {lat: -25.363, lng: 131.044};
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 30.3753, lng: 69.3451},
          zoom: 6
        });
         var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          title: 'Hello World!'
        });
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB1RaWWrKsEf2xeBjiZ5hk1gannqeFxMmw&callback=initMap"
    async defer></script>
@endif


@stop