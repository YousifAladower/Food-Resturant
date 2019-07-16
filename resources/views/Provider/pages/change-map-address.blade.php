@extends("Provider.layouts.master")

@section('title')
    {{ $title }}
@endsection

@section('class')
    {{ $class }}
@endsection

@section("content")



    <main id="map-content" class="map-content page-content py-5">

        <header class="page-header mt-4 text-center">
            <h1 class="page-title h2 font-body-bold">تغيير الموقع</h1>
            <p class="description text-gray font-body-md mt-3">يرجى تحديد الموقع عبر الخريطة</p>
            {{--<p id="register-map-address" class="description text-gray font-body-md mt-3"></p>--}}
        </header>
        <div class="container">
            <div class="row">

                <div class="col-lg-8 col-sm-10 col-12 mx-auto font-body-bold mb-5 text-center">
                    <div class="embed-responsive embed-responsive-16by9 my-4 shadow-bottom">

                        <form id="form" action="{{ url("/restaurant/profile/change-map-address") }}" method="POST">
                            {{ csrf_field() }}
                            <input id="branch-lat" type="hidden" value="{{ auth("provider")->user()->latitude }}" />
                            <input id="branch-lng" type="hidden" value="{{ auth("provider")->user()->longitude }}" />
                            <input id="branch-latlng" type="hidden" value="({{auth("provider")->user()->latitude }},{{auth("provider")->user()->longitude }})" />
                            

                            <input type="hidden" name="new-lat" id="new-lat" value="{{ auth("provider")->user()->latitude }}" />
                            <input type="hidden" name="new-lng" id="new-lng" value="{{ auth("provider")->user()->longitude }}" />

                        </form>

                            <div id="map" class="embed-responsive-item"></div>


                    </div>

                    @if($errors->has("new-lat") || $errors->has("new-lng"))

                        <div class="alert alert-danger">
                            {{ $errors->first("new-lat") }}
                        </div>

                    @endif

                    <Button type="submit" form="form" class="btn btn-primary px-5 no-decoration">تأكيد</Button>
                    <a href="{{ url("/restaurant/profile") }}">
                        <button  class="btn btn-default px-5 no-decoration">رجوع</button>
                    </a>
                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->

@endsection
@section('script')

    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDKZAuxH9xTzD2DLY2nKSPKrgRi2_y0ejs&callback=initMap">
    </script>
    
    
     
 
   <script>
     
   
            
    var map, infoWindow , marker ,geocoder;
        
    var messagewindow;
    var markers = [];

    var prevlat;
    var prevLng

    var SelectedLatLng = "";
    var SelectedLocation = "";
    
     var prevlat = $("#branch-lat").val();
     var prevLng = $("#branch-lng").val();
 

        initMap();

      

  function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: parseInt(prevlat), lng: parseInt(prevLng)},
            zoom: 15
            
        });
        
        
          infoWindow = new google.maps.InfoWindow;
          geocoder = new google.maps.Geocoder();
          
          
                      infoWindow.setPosition({lat: parseFloat(prevlat), lng: parseFloat(prevLng)});
                     infoWindow.setContent('{{$branch -> ar_name}}');
                      infoWindow.open(map);
                   

         
         if($("#branch-latLng").val() !=""){
            prevlat = $("#branch-lat").val();
            prevLng = $("#branch-lng").val();
        }else{
            prevlat = -34.397;
            prevLng = 150.6444;
        }
        

        if($("#branch-latlng").val() === ""){
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    //infoWindow.setPosition(pos);
                   // infoWindow.setContent('Location found.');
                   // infoWindow.open(map);
                    map.setCenter(pos);
                    
                     var marker = new google.maps.Marker({
                            position: new google.maps.LatLng(pos),
                              
                            map: map,
                            title: 'موقعك الحالي'
                        });
                         
                         
                         
                           
                  
                        
                        
                        
                }, function() {
                    handleLocationError(true, infoWindow, map.getCenter());
                });
            } else {
                // Browser doesn't support Geolocation
                handleLocationError(false, infoWindow, map.getCenter());
            }
        }else{
            
              
          addMarker( "(" + parseInt($('#branch-lat').val()) + "," + parseInt($('#branch-lng').val()) +")");
             
        }
       

        //addMarker(parseInt($(".shipping-latLng").val()));
        var geocoder = new google.maps.Geocoder();

        if($("#branch-latlng").val() !== ""){
            addMarker( "(" + parseInt($('#branch-lat').val()) + "," + parseInt($('#branch-lng').val()) +")");
        }else{

            google.maps.event.addListener(map, 'click', function(event) {
                SelectedLatLng = event.latLng;
                geocoder.geocode({
                    'latLng': event.latLng
                }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            deleteMarkers();
                            addMarkerRunTime(event.latLng);
                            SelectedLocation = results[0].formatted_address;
                            splitLatLng(String(event.latLng));
                            $("#register-latlng").val(SelectedLatLng);
                            
                           $("#register-map-address").val(SelectedLocation);
                            
                            
                        
                        }
                    }
                });
            });

        }


     

        function addMarker(location) {
            // var marker = new google.maps.Marker({
            //     position: location,
            //     map: map
            // });

            var marker = new google.maps.Marker({
                position: new google.maps.LatLng( parseInt($("#branch-lat").val()),parseInt($("#branch-lng").val())),
                map: map,
                title: '{{$branch -> ar_name}}'
            });
            

            var contentString = '<div id="content" style="width: 200px; height: 200px;"><h1>Overlay</h1></div>';
            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });


             google.maps.event.addListener(map, 'click', function(event) {
                SelectedLatLng = event.latLng;
                geocoder.geocode({
                    'latLng': event.latLng
                }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            deleteMarkers();
                            addMarkerRunTime(event.latLng);
                            SelectedLocation = results[0].formatted_address;
                            splitLatLng(String(event.latLng));
                            $("#branch-latlng").val(SelectedLatLng);
                             
                        }
                    }
                });
            });

            // To add the marker to the map, call setMap();
            marker.setMap(map);

        }



        function addMarkerRunTime(location) {
            var marker = new google.maps.Marker({
                position: location,
                map: map
            });
            markers.push(marker);
        }

        function setMapOnAll(map) {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(map);
            }
        }

        function clearMarkers() {
            setMapOnAll(null);
        }

        function deleteMarkers() {
            clearMarkers();
            markers = [];
        }

    }

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
    }

    function splitLatLng(latLng){

        var newString = latLng.substring(0, latLng.length-1);
        var newString2 = newString.substring(1);
        var trainindIdArray = newString2.split(',');
        var lat = trainindIdArray[0];
        var Lng  = trainindIdArray[1];

        $("#branch-lat").val(lat);
        $("#branch-lng").val(Lng);
        $("#new-lat").val(lat);
        $("#new-lng").val(Lng);
    }
          
    </script>
    
   
@endsection