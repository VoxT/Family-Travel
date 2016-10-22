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

function expandViewportToFitPlace(map, place) {
if (place.geometry.viewport) {
  map.fitBounds(place.geometry.viewport);
} else {
  map.setCenter(place.geometry.location);
  map.setZoom(17);
}
}

function route(origin_place_id, destination_place_id, travel_mode,
             directionsService, directionsDisplay) {
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

// begin result search map
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
    var map = new google.maps.Map(document.getElementById('map'), mapOptions);

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
  })

  // handler result item
  $('#things').click( function() {
    showInterestingThings(map, destination_place_id);
  });
}

function showInterestingThings(map, place_id) {
  var service = new google.maps.places.PlacesService(map);
  var infowindow = new google.maps.InfoWindow();
  service.getDetails({
        placeId: place_id
      }, function(place, status) {
        if (status === google.maps.places.PlacesServiceStatus.OK) {
          expandViewportToFitPlace(map, place);
          google.maps.event.addListener(marker, 'click', function() {
            infowindow.setContent('<div><strong>' + place.name + '</strong><br>' +
              'Place ID: ' + place.place_id + '<br>' +
              place.formatted_address + '</div>');
            infowindow.open(map, this);
          });
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
