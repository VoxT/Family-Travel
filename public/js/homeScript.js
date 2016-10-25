
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

$('.picker__input').datepicker({
  format: "yyyy/mm/dd",
  startDate: 'd',
  minDate: new Date(),
  });

$('.date-depart').click(function(){
  $('#date-depart').focus();
});

$('.date-return').click(function(){
  $('#date-return').focus();
});

$('.adults .dropdown-items li > a').click(function(e){
    $('#adults').val($(this).attr('data-value'));;
    $('.adults .js-dropdown-toggle-name').text($(this).attr('data-value'));
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
