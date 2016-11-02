 
$.datepicker.regional['vn'] = {
    monthNames: ['Tháng Một','Tháng Hai','Tháng Ba','Tháng Tư','Tháng Năm','Tháng Sáu',
    'Tháng Bảy','Tháng Tám','Tháng Chín','Tháng Mười','Tháng Mười Một','Tháng Mười Hai'],
    dayNamesMin: ['CN','Thứ 2','Thứ 3','Thứ 4','Thứ 5','Thứ 6','Thứ 7']
  };
 $.datepicker.setDefaults($.datepicker.regional['vn']);

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

// select date
var weekday = new Array();
weekday[1] = "Thứ 2";
weekday[2] = "Thứ 3";
weekday[3] = "Thứ 4";
weekday[4] = "Thứ 5";
weekday[5] = "Thứ 6";
weekday[6] = "Thứ 7";
weekday[0] = "Chủ Nhật";

function currentDate() {
  var today = new Date(),
      day  = weekday[today.getDay()],  
      month = today.getMonth() + 1,
      dd = today.getDate(),
      yyyy = today.getFullYear();

    $('.date-depart .month').text('Tháng ' + month);
    $('.date-depart .day').text(dd);
    $('.date-depart .dayofweek').text(day);
    $('#date-depart').val(yyyy + '-' + ((month < 10)? ('0' + month):month)  + '-' + ((dd < 10)? ('0'+ dd):dd));
}
currentDate();

$('#date-depart').datepicker({
  dateFormat: "yy-mm-dd",
  minDate: new Date(),
  firstDay: 1,
  onSelect: function() {
    var date = $(this).datepicker('getDate'),
    day  = weekday[date.getDay()],  
    month = date.getMonth() + 1;
    $('.date-depart .month').text('Tháng ' + month);
    $('.date-depart .day').text(date.getDate());
    $('.date-depart .dayofweek').text(day);
    $('#date-return').datepicker('option', 'minDate', new Date($('#date-depart').val()));
    if($('#date-return').val() != '')
      changeReturnDateInput();
  }
});

$('#date-return').datepicker({
  dateFormat: "yy-mm-dd",
  minDate: $('#date-depart').val(),
  firstDay: 1,
  onSelect: function() {
    changeReturnDateInput();
  }
});

function changeReturnDateInput() {
    var date = new Date($('#date-return').val());
    day  = weekday[date.getDay()],  
    month = date.getMonth() + 1;
    $('.date-return').parent().removeClass('stripe');
    $('.date-return').html('<div class="month">' + 'Tháng ' + month + '</div><div class="day">' + date.getDate() + '</div><div class="dayofweek">' + day + '</div>')
}

$('.date-depart').click(function(){
  $('#date-depart').focus();
});

$('.date-return').click(function(){
  $('#date-return').focus();
});
$('#ui-datepicker-div').hide();
// select people
$('.adults .dropdown-items li > a').click(function(e){
    $('#adults').val($(this).attr('data-value'));;
    $('.adults .js-dropdown-toggle-name').text($(this).attr('data-value'));
});
$('.childrens .dropdown-items li > a').click(function(e){
    $('#childrens').val($(this).attr('data-value'));;
    $('.childrens .js-dropdown-toggle-name').text($(this).attr('data-value'));
});
$('.kid .dropdown-items li > a').click(function(e){
    if($(this).attr('data-value') > $('#adults').val()) {
      // $("#exceed").tooltip({ 'animation': true, 'title': 'Số trẻ không được quá số người lớn.' });
      //  $('#exceed').tooltip('show'); 
      //  setTimeOut(function(){$('#exceed').tooltip('hide');}, 2000);
       return; // Cần chỉnh lại thứ tự js, jquery - jqueryUi - bootstrapjs
    }
    $('#kid').val($(this).attr('data-value'));;
    $('.kid .js-dropdown-toggle-name').text($(this).attr('data-value'));
});
$('#service-class .dropdown-items li > a').click(function(e){
    $('#cabinclass').val($(this).attr('data-value'));;
    $('#service-class .js-dropdown-toggle-name').text($(this).text());
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
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else {
    alert("Geolocation is not supported by this browser.");
  }
}
function showPosition(position) {
  var lat = position.coords.latitude;
  var lng = position.coords.longitude;
  console.log(lat);
}
getLocation();