
var map, bounds, placeMarker = [];
var iconType = {
          'restaurant':
                {
                  icon : "/images/icons/restaurant.png"
                },
         
          'museum':
               { 
                icon : "/images/icons/museum.png"
             },
          'park':
               {
                icon  : "/images/icons/park.png"
              },
          'zoo':
               {
                icon  : "/images/icons/zoo.png"
              },        
          'amusement_park':
                {
                  icon : "/images/icons/amuseum_park.png"
                },
          'church':
          {
            icon : "images/icons/church.png"
          },

          
          'art_gallery':
               {
                icon  : "/images/icons/art.png"
              }
        
         };

function reportMap() {
	var mapOptions = {
      center: {lat: 10.45, lng: 106.40},
      zoom: 15,
      
      mapTypeControl: true,
      mapTypeControlOptions: {
        style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
          mapTypeIds: [
              google.maps.MapTypeId.ROADMAP,
              google.maps.MapTypeId.SATELLITE
          ]
      },
      styles: [
              {elementType: 'labels.text.fill', stylers: [{color: '#523735'}]},
              {elementType: 'labels.text.stroke', stylers: [{color: '#f5f1e6'}]},{featureType:"water",stylers:[{visibility:"simplified"},{color:"#3fb3de"}]},{featureType:"transit.line",elementType:"labels.text.stroke",stylers:[{color:"#ffffff"}]},{featureType:"transit.line",elementType:"labels.text.fill",stylers:[{color:"#ffffff"}]},{featureType:"transit.line",elementType:"geometry",stylers:[{color:"#ffffff"}]},{featureType:"transit.line",elementType:"geometry.fill",stylers:[{color:"#cccccc"}]},{featureType:"road.highway",elementType:"geometry.fill",stylers:[{color:"#bbbbbb"}]},{featureType:"road.highway",elementType:"geometry.stroke",stylers:[{color:"#ffffff"}]},{featureType:"road.local",elementType:"geometry.fill",stylers:[{color:"#ffffff"}]},{featureType:"road.local",elementType:"geometry.stroke",stylers:[{color:"#d1d1d1"}]},{featureType:"road.arterial",elementType:"geometry.fill",stylers:[{color:"#ffffff"}]},{featureType:"road.arterial",elementType:"geometry.stroke",stylers:[{color:"#d1d1d1"}]},{featureType:"road",elementType:"labels.icon",stylers:[{lightness:50}]},{featureType:"administrative",elementType:"labels.text.fill",stylers:[{color:"#393c3d"}]},{featureType:"poi",elementType:"geometry.fill",stylers:[{lightness:30}]},{featureType:"landscape",stylers:[{lightness:30},{saturation:-50}]}]
    }
    map = new google.maps.Map($('#reportMap')[0], mapOptions);
  	bounds = new google.maps.LatLngBounds();

    for(var i in place_list ) {
    	addPlaceMarker(place_list[i]);
    }
	map.fitBounds(bounds);
}

function addPlaceMarker(place) {
	var marker = new google.maps.Marker({
        map: map,
        type: place.type,
        position: {lat: place.lat, lng: place.lng},
        icon : iconType[place.type].icon
      });
		
	marker.setMap(map);
    bounds.extend(marker.getPosition());
	// Switch icon on marker mouseover and mouseout
	google.maps.event.addListener(marker, 'mouseover', function() {
	    marker.setIcon('/images/icons/art.png');
	  });
	google.maps.event.addListener(marker, 'mouseout', function() {
	    marker.setIcon(iconType[place.type].icon);
	  });
	placeMarker.push(marker);
	var marker_num = placeMarker.length - 1;
	$('.list-group-item[geo-id="'+ marker_num + '"]').attr('onmouseover', 'hoverMaker('+marker_num+')');
	$('.list-group-item[geo-id="'+ marker_num + '"]').attr('onmouseout', 'unHoverMaker('+marker_num+')');
}

function hoverMaker(marker_num) {
	placeMarker[marker_num].setIcon('/images/icons/art.png');
}

function unHoverMaker(marker_num) {
	placeMarker[marker_num].setIcon(iconType[placeMarker[marker_num].type].icon);
}