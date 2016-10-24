
var key = 'AIzaSyCvf3SMKYOCFlAtjUTKotmrF6EFrEk2a40';

// Carousel slide effect
$('#myCarousel').on('slide.bs.carousel', function() {
  if ($('.carousel-inner .item:last').hasClass('active')) {
    $('.carousel-inner .item:first').addClass('animated fadeIn');
  } else {
    $('.item.active').next().addClass('animated fadeIn');
  }
  $('.item.active').addClass('animated fadeOut');
});

$('#myCarousel').on('slid.bs.carousel', function() {
  $('.item').removeClass('animated fadeIn fadeOut')
});

$('.left').click(function() {
  if ($('.carousel-inner .item:first').hasClass('active')) {
    $('.carousel-inner .item:last').addClass('animated fadeIn');
  } else {
    $('.item.active').prev().addClass('animated fadeIn');
  }
});

// switch button animate
var focus = 0;
$(".btn-switch").click( function() {
  if ( focus === 180)
    focus = 0;
  else focus += 180;
  $(this).css("transform" , "rotate("+ focus +"deg)");
  var origin_input = $('#origin-input').val();
  $('#origin-input').val($('#destination-input').val());
  $('#destination-input').val(origin_input);
});

// begin autocomplete searchbox
function autocompletePlace() {
  var origin_place = document.getElementById('origin-input');
  var destination_place = document.getElementById('destination-input');

  var options = {
    types: ['(cities)']
  };

  var origin_autocomplete = new google.maps.places.Autocomplete(origin_place, options);
  origin_autocomplete.addListener('place_changed', function() {
    var place = origin_autocomplete.getPlace();
    if (!place.geometry) {
      window.alert("Autocomplete's returned place contains no geometry");
      return;
    }
    // $('#origin_place_id').val(place.place_id);
    // $('#origin_place_name').val(place.name);
  })

  var destination_autocomplete = new google.maps.places.Autocomplete(destination_place, options);
  destination_autocomplete.addListener('place_changed', function() {
    var place = destination_autocomplete.getPlace();
    if (!place.geometry) {
      window.alert("Autocomplete's returned place contains no geometry");
      return;
    }
    // $('#destination_place_id').val(place.place_id);
    // $('#destination_place_name').val(place.name);
  })
}
// end autocomplete searchbox

// begin result search map
var map, placeService, infoWindow;
var markers = [];
var iconType = {
         
          'museum':
               { 
                icon : "images/icons/museum.png"
             },
          'park':
               {
                icon  : "images/icons/park.png"
              },
          'zoo':
               {
                icon  : "images/icons/zoo.png"
              },
          'art_gallery':
               {
                icon  : "images/icons/art.png"
              }
        
         };

function initMap() {
  var origin_place_id = null;
  var destination_place_id = null;
  var origin_input = document.getElementById('origin-input');
  var destination_input = document.getElementById('destination-input');

  $.when(
    $.ajax({
      type: 'GET',
      url: "https://maps.googleapis.com/maps/api/place/textsearch/json",
      data: {
        query: origin_place_name,
        key: key
      },
      success: function(data){
          origin_place_id = data.results[0]['place_id'];
          origin_input.value = data.results[0]['name'];
    }}),
    $.ajax({
      type: 'GET',
      url: "https://maps.googleapis.com/maps/api/place/textsearch/json",
      data: {
        query: destination_place_name,
        key: key
      },
      success: function(data){
          destination_place_id = data.results[0]['place_id'];
          destination_input.value = data.results[0]['name'];
    }})
  ).done(function (ajax1, ajax2) {
    var travel_mode = 'DRIVING';
    var mapOptions = {
      center: {lat: -33.8688, lng: 151.2195},
      zoom: 13,
      
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
    map = new google.maps.Map(document.getElementById('map'), mapOptions);
    placeService = new google.maps.places.PlacesService(map);
    infoWindow = new google.maps.InfoWindow({
          content: document.getElementById('info-content')
          });

  	var options = {
  	types: ['(cities)']
  	};

    var directionsService = new google.maps.DirectionsService;
    var directionsDisplay = new google.maps.DirectionsRenderer;
    directionsDisplay.setMap(map);

    var origin_autocomplete = new google.maps.places.Autocomplete(origin_input, options);
    origin_autocomplete.bindTo('bounds', map);
    var destination_autocomplete =
        new google.maps.places.Autocomplete(destination_input, options);
    destination_autocomplete.bindTo('bounds', map);

    origin_autocomplete.addListener('place_changed', function() {
      var place = origin_autocomplete.getPlace();
      if (!place.geometry) {
        window.alert("Autocomplete's returned place contains no geometry");
        return;
      }

      // If the place has a geometry, store its place ID and route if we have
      // the other place ID
      origin_place_id = place.place_id;
      route(origin_place_id, destination_place_id, travel_mode,
            directionsService, directionsDisplay);
    });

    destination_autocomplete.addListener('place_changed', function() {
      var place = destination_autocomplete.getPlace();
      if (!place.geometry) {
        window.alert("Autocomplete's returned place contains no geometry");
        return;
      }

      // If the place has a geometry, store its place ID and route if we have
      // the other place ID
      destination_place_id = place.place_id;
      route(origin_place_id, destination_place_id, travel_mode,
            directionsService, directionsDisplay);
    });

    route(origin_place_id, destination_place_id, travel_mode,
            directionsService, directionsDisplay);

    // handler result item
    $('#things').click( function() {
      showInterestingThings(destination_place_id);
    });
  })

}

function expandViewportToFitPlace(place) {
  if (place.geometry.viewport) {
    map.fitBounds(place.geometry.viewport);
  } else {
    map.setCenter(place.geometry.location);
    map.setZoom(17);
  }
}

function route(origin_place_id, destination_place_id, travel_mode, directionsService, directionsDisplay) {
  if (!origin_place_id || !destination_place_id) {
    return;
  }
  directionsService.route({
      origin: {'placeId': origin_place_id},
      destination: {'placeId': destination_place_id},
      travelMode: travel_mode
    }, function(response, status) {
      if (status === 'OK') {
        directionsDisplay.setDirections(response);
      } else {
        window.alert('Directions request failed due to ' + status);
      }
    });
}

function showInterestingThings(place_id) {
  placeService = new google.maps.places.PlacesService(map);
  placeService.getDetails({
        placeId: place_id
      }, function(place, status) {
        if (status === google.maps.places.PlacesServiceStatus.OK) {
          map.panTo(place.geometry.location);
          map.setZoom(13);
          map.addListener('idle', search);
        }
      });
}

function getCurrentLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var pos = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };

      infoWindow.setPosition(pos);
      infoWindow.setContent('Location found.');
      map.setCenter(pos);
    }, function() {
      handleLocationError(true, infoWindow, map.getCenter());
    });
  } else {
    // Browser doesn't support Geolocation
    handleLocationError(false, infoWindow, map.getCenter());
  }
}


// search interesting things
function search() {
 
  var searchParams = {
    bounds: map.getBounds(),
    //types: ['park'],
    types: ['museum','park','zoo'],
    keyword: 'Attractions'
  };
  placeService.radarSearch(searchParams, callback);
}

function callback(results, status) {
  if (status === google.maps.places.PlacesServiceStatus.OK) {
  
    // clearResults();
    // clearMarkers();
 
    for (var i = 0, results; result = results[i]; i++) {
       addMarker(result);//, i);
    }
  }
}

function addMarker(place) {

  placeService.getDetails({placeId: place.place_id},
    function(result, status) {
      if (status !== google.maps.places.PlacesServiceStatus.OK) {
        return;
      }
      var icon = intersectionJson(iconType, result.types);
      if(!icon) {
        icon.push('lake');
      }
      var marker = new google.maps.Marker({
            map: map,
            position: result.geometry.location,
            //animation: google.maps.Animation.DROP,
            icon : iconType[icon[0]].icon
          });
      //mousover 
      google.maps.event.addListener(marker, 'click', function() {
          infoWindow.open(map, marker);
          buildIWContent(result);
      }); 
     // setTimeout(dropMarker(i), i * 100);
    }); 
}

function intersectionJson(a, b)
{
  var result = [];
  for(var x in a) {
    for(y in b) {
      if( x == b[y])
        result.push(b[y]);
    }
  }
  return result;
}

function clearMarkers() {
  for (var i = 0; i < markers.length; i++) {
    if (markers[i]) {
      markers[i].setMap(null);
    }
  }
  markers = [];
}

function clearResults() {
  var results = document.getElementById('results');
  while (results.childNodes[0]) {
    results.removeChild(results.childNodes[0]);
  }
} 

function dropMarker(i) {
  return function() {
    markers[i].setMap(map);
  };
}

function showInfoWindow(result) {
  marker = this;
  //infoWindow.setContent(buildIWContent(place);
  console.log(JSON.stringify(result));
  infoWindow.open(map, marker);
  buildIWContent(result);
}
          
  // Load the place information into the HTML elements used by the info window.
function buildIWContent(place) {
  document.getElementById('iw-icon').innerHTML = '<img class=" image_place"' +
      'src="' + place.photos[0].getUrl({'maxWidth': 100, 'maxHeight': 100}) + '"/>';
  document.getElementById('iw-url').innerHTML = '<b><a   href="' + place.url +
      '">' + place.name + '</a></b>';
  if (place.rating) {
    var ratingHtml = '';
    for (var i = 0; i < 5; i++) {
      if (place.rating < (i + 0.5)) {
        ratingHtml += '<span style="font-size:200%;color:#D0CDCD;" >&#9734;</span>'
      } else {
        ratingHtml += '<span style="font-size: 200%;color:yellow;">&#9733;</span>'
      }
    document.getElementById('iw-rating-row').style.display = '';
    document.getElementById('iw-rating').innerHTML = ratingHtml;
    }
  } else {
    document.getElementById('iw-rating-row').style.display = 'none';
  }   

}