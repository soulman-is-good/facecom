var map = null;
var geoc = null;

///////////////////////////////////////////////////////////////////////////
  function CustomMarker(latlng,  map, icon,title) {
    this.latlng_ = latlng;
    this.icon = icon;
    this.title = title;

    // Once the LatLng and text are set, add the overlay to the map.  This will
    // trigger a call to panes_changed which should in turn call draw.
    this.setMap(map);
  }
/////////////////////////////////////////////////////////////////////


function handleNoGeolocation(){
    //we'll use yandex then...
    $.getScript('//api-maps.yandex.ru/2.0-stable/?lang=ru-RU&coordorder=longlat&load=package.map',function(){
        ymaps.ready(function(){
            map.setCenter(new google.maps.LatLng(ymaps.geolocation.latitude, ymaps.geolocation.longitude),13);
        })
    })
}
function placeMarker(location,id,icon) {
  return new CustomMarker(location, map, icon,id);
}
$(function(){
    $.getScript('//www.google.com/jsapi', function(G){
        google.load('maps','3',{other_params:'sensor=false','callback':function(){
////////////////////////////////
//Custom marker configuration
////////////////////////////////
  CustomMarker.prototype = new google.maps.OverlayView();

  CustomMarker.prototype.draw = function() {
    var me = this;

    // Check if the div has been created.
    var div = this.div_;
    if (!div) {
      // Create a overlay text DIV
      div = this.div_ = document.createElement('DIV');
      // Create the DIV representing our CustomMarker
      div.style.border = "5px solid #FFF";
      div.style.boxShadow = "3px 3px 5px #ccc";
      div.style.borderRadius = "45px";
      div.style.position = "absolute";
      div.style.paddingLeft = "0px";
      div.style.cursor = 'pointer';
      div.style.overflow = 'hidden';

      var img = document.createElement("img");
      img.src = this.icon;
      img.width="80";
      img.style.borderRadius = "45px";
      div.appendChild(img);
      var self = this;
      google.maps.event.addDomListener(div, "click", function(event) {
        location.href = self.title;
        google.maps.event.trigger(me, "click");
      });

      // Then add the overlay to the DOM
      var panes = this.getPanes();
      panes.overlayImage.appendChild(div);
    }

    // Position the overlay 
    var point = this.getProjection().fromLatLngToDivPixel(this.latlng_);
    if (point) {
      div.style.left = point.x + 'px';
      div.style.top = point.y + 'px';
    }
  };

  CustomMarker.prototype.remove = function() {
    // Check if the overlay was on the map and needs to be removed.
    if (this.div_) {
      this.div_.parentNode.removeChild(this.div_);
      this.div_ = null;
    }
  };

  CustomMarker.prototype.getPosition = function() {
   return this.latlng_;
  };
            $.get('/placemarks/get',function(m){
                $('#placemarks').height(230);
                map = new google.maps.Map(document.getElementById("placemarks"),{
                    zoom: 13,
                    center: new google.maps.LatLng(-34.397, 150.644),
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });
                //$('#placemarks').css('display','none');
                if(m.length>0){
                    var bounds = new google.maps.LatLngBounds();
                    $('#placemarks').css('display','block');
                    //map.setCenter(new google.maps.LatLng(m[0]['lat'], m[0]['long']), 13);
                    for(i in m){
                        var myLatlng = new google.maps.LatLng(m[i]['lat'], m[i]['long']);
                        bounds.extend(myLatlng);  
                        placeMarker(myLatlng,m[i].id,m[i].filename);
                    }
                   map.fitBounds(bounds);
                }else{
                    // Try W3C Geolocation (Preferred)
                    if(navigator.geolocation && 0) {
                      navigator.geolocation.getCurrentPosition(function(position) {
                        map.setCenter(new google.maps.LatLng(position.coords.latitude,position.coords.longitude),13);
                      }, function() {
                        handleNoGeolocation();
                      });
                    }
                    // Browser doesn't support Geolocation
                    else {
                      handleNoGeolocation();
                    }
                }
            },'json');
        }})
        $('#marks').click(function(){
          $(this).css('display','none');
          $('#save_marks').css('display','inline');
          $('#placemarks').css({'display':'block'}).addClass('editMap');
          google.maps.event.addListener(map, 'click', function(event) {
            placeMarker(event.latLng);
          });
          return false;
        })
        $('#save_marks').click(function(){
          $(this).css('display','none');
          $('#marks').css('display','inline');
          $('#placemarks').removeClass('editMap');
          google.maps.event.removeListener(map, 'click');
          return false;
        })
    })
})

