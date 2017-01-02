
$(document).ready(function() {

function outbounddatepicker() {
	$('#outbounddate').datepicker({
	  dateFormat: "yy-mm-dd",
	  minDate: new Date(),
	  firstDay: 1,
	  onSelect: function() {
	    var date = $(this).datepicker('getDate'),
	    	day = date.getDate(),
	    	month = date.getMonth() + 1,
	    	year = date.getFullYear();
	    $('#planeModal .depart span').text(day + '/' + month + '/' + year);
	    $('#inbounddate').datepicker('option', 'minDate', new Date($('#outbounddate').val()));
	    if($('#inbounddate').val() != '')
      		changeOubountDate();
	  }
	}).datepicker("setDate", request.outbounddate);
}
function inbounddatepicker() {
	$('#inbounddate').datepicker({
	  dateFormat: "yy-mm-dd",
	  minDate: $('#outbounddate').val(),
	  firstDay: 1,
	  onSelect: function() {
	    var date = $(this).datepicker('getDate'),
	    	day = date.getDate(),
	    	month = date.getMonth() + 1,
	    	year = date.getFullYear();
	    $('#planeModal .arrival span').text(day + '/' + month + '/' + year);
	  }
	}).datepicker("setDate", request.inbounddate);
}

outbounddatepicker();
inbounddatepicker();

function changeOubountDate(){
	var date = new Date($('#inbounddate').val()),
	    	day = date.getDate(),
	    	month = date.getMonth() + 1,
	    	year = date.getFullYear();
	    $('#planeModal .arrival span').text(day + '/' + month + '/' + year);
}

$('#depart').click(function() {
	$('#outbounddate').show().focus().hide();
});

$('#arrival').click(function() {
	$('#inbounddate').show().focus().hide();
});

$('#moreInfo').popover({
	placement: 'bottom',
	html: true,
	content: $('.popover-flight').html()
});
var check = '';
$('#moreInfo').on('show.bs.popover', function () {
	check = $('.popover-flight .cabinclass input[name="cabinclass"]:checked').val();
});
$('#moreInfo').on('shown.bs.popover', function () {
	$('#' + $(this).attr('aria-describedby') + ' .popover-content input[name="cabinclass"]'+ '[value="' + check +'"]').prop('checked', true);
    $('#' + $(this).attr('aria-describedby') + ' .popover-content #adults').val($('.popover-flight #adults').val());
    $('#' + $(this).attr('aria-describedby') + ' .popover-content #childrens').val($('.popover-flight #childrens').val());
    $('#' + $(this).attr('aria-describedby') + ' .popover-content #kid').val($('.popover-flight #kid').val());
});

$('#moreInfo').on('hide.bs.popover', function () {
    $('.popover-flight #adults').val($('#' + $(this).attr('aria-describedby') + ' .popover-content #adults').val());
    $('.popover-flight #childrens').val($('#' + $(this).attr('aria-describedby') + ' .popover-content #childrens').val());
    $('.popover-flight #kid').val($('#' + $(this).attr('aria-describedby') + ' .popover-content #kid').val());
    $('.popover-flight .cabinclass input[name="cabinclass"]' + '[value="' + $('#' + $(this).attr('aria-describedby') + ' .popover-content input[name="cabinclass"]:checked').val() +'"]').prop('checked', true);
});

$(document).on('change', '#adults, #childrens, #kid, .cabinclass input[name="cabinclass"]', function(){
	$('#moreInfo > span:first-child').text(parseInt($('#adults').val()) + parseInt($('#childrens').val()) + parseInt($('#kid').val()) + ' Người, Ghế ' + $('.cabinclass input[name="cabinclass"]:checked').val());
});

$(document).on('change', '#guests, #rooms', function(){
	$('#moreHotelInfo > span:first-child').text(parseInt($('#guests').val()) + ' Người, ' + parseInt($('#rooms').val()) + ' Phòng');
});

$('#adults').val(request.adults);
$('#childrens').val(request.children);
$('#kid').val(request.infants);
$('.cabinclass input[name="cabinclass"][value="'+ request.cabinclass +'"]').prop('checked', true);
$('#moreInfo > span:first-child').text(parseInt(request.adults) + parseInt(request.children) + parseInt(request.infants) + ' Người, Ghế ' + request.cabinclass);

$('#rooms').val(Math.round(parseInt(request.adults)/2));
$('#guests').val(parseInt(request.adults) + parseInt(request.children));
$('#moreHotelInfo > span:first-child').text(parseInt(request.adults) + parseInt(request.children) + ' Người, ' + Math.round(parseInt(request.adults)/2) + ' Phòng');

$('#moreHotelInfo').popover({
	placement: 'bottom',
	html: true,
	content: $('.popover-hotel').html()
});

$('#moreHotelInfo').on('shown.bs.popover', function () {
    $('#' + $(this).attr('aria-describedby') + ' .popover-content #guests').val($('.popover-hotel #guests').val());
    $('#' + $(this).attr('aria-describedby') + ' .popover-content #rooms').val($('.popover-hotel #rooms').val());
});

$('#moreHotelInfo').on('hide.bs.popover', function () {
    $('.popover-hotel #guests').val($('#' + $(this).attr('aria-describedby') + ' .popover-content #guests').val());
    $('.popover-hotel #rooms').val($('#' + $(this).attr('aria-describedby') + ' .popover-content #rooms').val());
});

$(".fadeLeft").on('show.bs.modal', function () {
  setTimeout( function() {
    $(".modal-backdrop").addClass("modal-backdrop-left");
  }, 0);
});

$("#loginModal, #registerModal, #imageModal").on('show.bs.modal', function () {
  setTimeout( function() {
    $(".modal-backdrop").last().addClass("modal-backdrop-top");
  }, 0);
});

// car
$('#pickupdate-input').datepicker({
	  dateFormat: "yy-mm-dd",
	  minDate: new Date(),
	  firstDay: 1,
	  onSelect: function() {
	    var date = $(this).datepicker('getDate'),
	    	day = date.getDate(),
	    	month = date.getMonth() + 1,
	    	year = date.getFullYear();
	    $('#pickupdate span').text(day + '/' + month + '/' + year);
	    $('#dropoffdate-input').datepicker('option', 'minDate', new Date($('#pickupdate-input').val()));
	    changeDropOffDate();
	  }
	}).datepicker("setDate", request.outbounddate);

$('#dropoffdate-input').datepicker({
	  dateFormat: "yy-mm-dd",
	  minDate: $('#pickupdate-input').val(),
	  firstDay: 1,
	  onSelect: function() {
	    var date = $(this).datepicker('getDate'),
	    	day = date.getDate(),
	    	month = date.getMonth() + 1,
	    	year = date.getFullYear();
	    $('#dropoffdate span').text(day + '/' + month + '/' + year);
	  }
	}).datepicker("setDate", request.inbounddate);

function changeDropOffDate() {
	var date = new Date($('#dropoffdate-input').val()),
	    	day = date.getDate(),
	    	month = date.getMonth() + 1,
	    	year = date.getFullYear();
	    $('#dropoffdate span').text(day + '/' + month + '/' + year);
}

$('#dropoffdate').click(function() {
	$('#dropoffdate-input').show().focus().hide();
})

$('#pickupdate').click(function() {
	$('#pickupdate-input').show().focus().hide();
});

$('#checkindate').datepicker({
  dateFormat: "yy-mm-dd",
  minDate: new Date(),
  firstDay: 1,
  onSelect: function() {
    var date = $(this).datepicker('getDate'),
    	day = date.getDate(),
    	month = date.getMonth() + 1,
    	year = date.getFullYear();
    $('#hotelModal .depart span').text(day + '/' + month + '/' + year);
    $('#checkoutdate').datepicker('option', 'minDate', new Date($('#checkindate').val()));
    changeCheckOutDate();
  }
}).datepicker("setDate", request.outbounddate);


$('#checkoutdate').datepicker({
  dateFormat: "yy-mm-dd",
  minDate: $('#checkindate').val(),
  firstDay: 1,
  onSelect: function() {
    var date = $(this).datepicker('getDate'),
    	day = date.getDate(),
    	month = date.getMonth() + 1,
    	year = date.getFullYear();
    $('#hotelModal .arrival span').text(day + '/' + month + '/' + year);
  }
}).datepicker("setDate", request.inbounddate);

function changeCheckOutDate() {
	var date = new Date($('#checkoutdate').val()),
    	day = date.getDate(),
    	month = date.getMonth() + 1,
    	year = date.getFullYear();
    $('#hotelModal .arrival span').text(day + '/' + month + '/' + year);
}

$('#hotelModal .depart').click(function() {
	$('#checkindate').show().focus().hide();
})

$('#hotelModal .arrival').click(function() {
	$('#checkoutdate').show().focus().hide();
});

})

// set request date
var outbounddate = new Date(request.outbounddate),
	day = outbounddate.getDate(),
	month = outbounddate.getMonth() + 1,
	year = outbounddate.getFullYear();
	$('#planeModal .depart span').text(day + '/' + month + '/' + year);
	$('#carModal .depart span').text(day + '/' + month + '/' + year);
	$('#hotelModal .depart span').text(day + '/' + month + '/' + year);

var inbounddate = '';
if(request.inbounddate != '') {
	inbounddate = new Date(request.inbounddate),
	day = inbounddate.getDate(),
	month = inbounddate.getMonth() + 1,
	year = inbounddate.getFullYear();
	$('#planeModal .arrival span').text(day + '/' + month + '/' + year);
	$('#carModal .arrival span').text(day + '/' + month + '/' + year);
	$('#hotelModal .arrival span').text(day + '/' + month + '/' + year);
}

// open flight details modal
$(document).on('click', '.details-link', function(e){
	var dom = $(e.target).closest('div[class^="result-item"]');
	renderFlightDetails(dom.attr('data-id'));
	$('#flightdetailsmodal').modal('show');
});

// hotel details modal
$(document).on('click', '#hotelModal .listing-item', function(e){
	renderHotelDetails($(this).attr('data-id'));
	$('#hoteldetailsmodal').modal('show');
})

$(document).on('click', '.result-item .item-select-button', function(e){
	var id = $(e.target).closest('div[class^="result-item"]').attr('data-id');
	var details = { input: flightinput, flight: flightlist[id] };
	redirectToBook(details, 'booking/flight');
});

$(document).on('click', '#flightdetailsmodal .item-select-button', function(e){
	var id = $(this).attr('data-target');
	var details = { input: flightinput, flight: flightlist[id] };
	redirectToBook(details, 'booking/flight');
});

$(document).on('click', '#hoteldetailsmodal #hotelbooking', function(e){
	var id = $('#hoteldetailsmodal .details').attr('data-target');
	var details = {input: hotelinput, hotel: hoteldetails[id]};
	redirectToBook(details, 'booking/hotel');
});


$(document).on('click', '#flight-search', function(e) {
	flightFlag = false;
	flightlist = {};
	flightinput = {};
	getAirPortCode($('#outbounddate').val(), $('#inbounddate').val(),
		 $('#adults').val(), $('#childrens').val(), $('#kid').val(), $('.cabinclass input[name="cabinclass"]:checked').val());
});

$(document).on('click', '#car-search', function(e) {

	if($('#dropoffdate-input').val() == '')
		$('#dropoffdate-input').show().focus().hide();
	else
		Car(entityid, entityid, $('#pickupdate-input').val() + 'T' + $('#pickuptime').val(), $('#dropoffdate-input').val() + 'T' + $('#dropofftime').val());
});

$(document).on('click', '#hotel-search', function(e){
	clearMarkers(hotelMarkers);
	hoteldetails = {};
	hotellist = {};
	hotelinput = {};
	hotelMarkers = [];
	hotelFlag = false;
	if($('#checkoutdate').val() == '')
		$('#checkoutdate').show().focus().hide();
	else
		Hotel($('#checkindate').val(), $('#checkoutdate').val(), $('#guests').val(), $('#rooms').val());
});

$(document).on('click', '#carModal .item-select-button', function (e) {
	var id = $(this).attr('data-id');
	var details = carList[id];
	redirectToBook(details, 'booking/car');
});

$(document).on('click', '#addPlace', function (e) {
	if(isLogin)
		postPlace();
	else $('#loginModal').modal();
});

$(document).on('click', '#current_report', function (e) {
	if(isLogin)
		window.open($(this).attr('url'), '_blank');
	else $('#loginModal').modal();
});

function postPlace() {
	var photos = [];
	for(var i in placeDetails.photos) {
		photos.push(placeDetails.photos[i].getUrl({'maxWidth': 1000, 'maxHeight': 1000})) ;
	}
	var icon = intersectionJson(iconType, placeDetails.types);
      if(!(icon.length > 0)) {
        icon.push('art_gallery');
      }
	$.ajax({
		url: 'api/v1/postPlace',
		method: 'post',
		data: {
			place: {
				name: placeDetails.name,
				address: placeDetails.formatted_address,
				place_type: icon[0],
				place_id: placeDetails.place_id,
				images: photos,
				location: {
					lat: placeDetails.geometry.location.lat(),
					lng: placeDetails.geometry.location.lng()
				},
				reviews: placeDetails.reviews,
				rates: placeDetails.rating,
				phone: placeDetails.international_phone_number,
				website: placeDetails.website
			}
		}
	}).done(function (data) {
		bookPlaceList.push(data.place_id);
		
	    $('.add .btn').html('<i class="fa fa-check" aria-hidden="true"></i>');
	    $('.add .btn').css('background', '#04c9a6');
	    $('.add .btn').attr('title', 'Đã thêm vào chuyến đi');
	    $('.add .btn').attr('id', 'removePlace');
	}).fail(function (e) {
		
	});
}

function renderFlightDetails(id) {
	var flight = flightlist[id];
	var outbound = flight.Outbound;
	var oSegment = outbound.segment;
	var inbound = flight.Inbound;
	var dSegment = inbound.segment;

	var flightDetailsTemplate = flightdetailitem;
	var detailsrowTemplate = detailsrow;

	var outboundTemp = '';
	for(var i in oSegment){
		outboundTemp += detailsrowTemplate.replace('{{origin}}', oSegment[i].originName)
										.replace('{{depart}}', oSegment[i].departureTime)
										.replace('{{destination}}', oSegment[i].destinationName)
										.replace('{{arrival}}', oSegment[i].arrivalTime)
										.replace('{{ocode}}', oSegment[i].originCode)
										.replace('{{dcode}}', oSegment[i].destinationCode)
										.replace('{{duration}}', oSegment[i].duration_h + ' giờ : ' + oSegment[i].duration_m + ' phút')
										.replace('{{carrierImage}}', oSegment[i].imageUrl)
										.replace('{{carrierName}}', oSegment[i].imageName)
										.replace('{{flightNumber}}', oSegment[i].imageName + ' - ' + oSegment[i].flightCode + oSegment[i].flightNumber);
		if((parseInt(i)+1) < oSegment.length) {
			var stoptime = (new Date(oSegment[parseInt(i) + 1].departureDate + ' ' + oSegment[parseInt(i) + 1].departureTime) 
						- new Date(oSegment[i].arrivalDate + ' ' + oSegment[i].arrivalTime))/3600000;
			outboundTemp += '<div class="stop-time">Điểm dừng chờ: <strong>' + oSegment[i].destinationName + '</strong> <span>' 
						+ parseInt(stoptime) + ' giờ : ' + parseInt((stoptime%1)*60) + ' Phút </span></div>';
		}
	}

	var inboundTemp = '';
	for(var i in dSegment){
		inboundTemp += detailsrowTemplate.replace('{{origin}}', dSegment[i].originName)
										.replace('{{depart}}', dSegment[i].departureTime)
										.replace('{{destination}}', dSegment[i].destinationName)
										.replace('{{arrival}}', dSegment[i].arrivalTime)
										.replace('{{ocode}}', dSegment[i].originCode)
										.replace('{{dcode}}', dSegment[i].destinationCode)
										.replace('{{duration}}', dSegment[i].duration_h + ' giờ : ' + dSegment[i].duration_m + ' phút')
										.replace('{{carrierImage}}', dSegment[i].imageUrl)
										.replace('{{carrierName}}', dSegment[i].imageName)
										.replace('{{flightNumber}}', dSegment[i].imageName + ' - '+ dSegment[i].flightCode + dSegment[i].flightNumber);
		if((parseInt(i)+1) < dSegment.length) {
			var stoptime = (new Date(dSegment[parseInt(i) + 1].departureDate + ' ' + dSegment[parseInt(i) + 1].departureTime) 
						- new Date(dSegment[i].arrivalDate + ' ' + dSegment[i].arrivalTime))/3600000;
			inboundTemp += '<div class="stop-time">Điểm dừng chờ: <strong>' + dSegment[i].destinationName + '</strong> <span>' 
						+ parseInt(stoptime) + ' giờ : ' + parseInt((stoptime%1)*60) + ' Phút </span></div>';
		}
	}

	$('#flightdetailsmodal .modal-body').html(
			flightDetailsTemplate.replace('{{originName}}', outbound.overall.originName)
								.replace('{{destinationName}}', outbound.overall.destinationName)
								.replace('{{departdate}}', flightinput.outboundDate)
								.replace('{{returndate}}', (flightinput.inboundDate != null)? '<b>Lượt Về: </b>' + flightinput.inboundDate : '' )
								.replace('{{outbound}}', outboundTemp)
								.replace('{{inbound}}', inboundTemp)
								.replace('{{passenger}}', parseInt(flightinput.adults) + parseInt(flightinput.children) + parseInt(flightinput.infants))
								.replace('{{cabinclass}}', flightinput.cabinClass)
								.replace('{{price}}', numberWithCommas(flight.Price))
								.replace('{{data-target}}', id)
		);
}

// render hotel details
function renderHotelDetails(id) {
	var hotel = hoteldetails[id];
	var template = hotelDetailsTemplate;

	var stars = '';
	for(var j = 1; j <= 5; j++){
		if(j <= hotel.hotel.star_rating)
			stars += '<span><i class="fa fa-star" aria-hidden="true"></i></span>';
		else 
			stars += '<span><i class="fa fa-star-o" aria-hidden="true"></i></span>';

	}

	var images_li = '';
	for(var i = 0; (i < 5) && (i < hotel.hotel.image_url.length); i++){
		images_li += '<li data-toggle="modal" data-target="#imageModal"><a href="#myGallery" data-slide-to="' 
					+ i + '"><img class="img-responsive first" src="http://' + hotel.hotel.image_url[i].url + '" alt="' + hotel.hotel.name + '"></a></li>';
	}

	var amenities = '';

	for(var i in hotel.hotel.amenities) {
		if ((i%3) == 0) {
            amenities += '<div class="row">'
		}
		amenities += 
              '<div class="col-md-4">'
                +'<img src="'+ hotel.hotel.amenities[i].image_url + '">'
                +'<h5>' + hotel.hotel.amenities[i].name +'</h5>'
                +'<p>';
        for(var j in hotel.hotel.amenities[i].amenities_details){
        	amenities += hotel.hotel.amenities[i].amenities_details[j].name + ', ';
        }
        amenities = amenities.replace(/, $/, "") + ".";
        amenities += '</p> </div>';
        if (((i+1)%3) == 0) {
            amenities += '</div>';
		} 
	}
    if (((i%3) -2) != 0) {
        amenities += '</div>';
	}

	var reviews = '';
	if(hotel.reviews.reviews_count > 0) {
		for(var i in hotel.reviews.categories) {
			if ((i%2) == 0) {
	            reviews += '<div class="row">'
			}
			reviews += 
	              '<div class="col-md-6">'
	              +'<span class="badge">' + hotel.reviews.categories[i].score/10 +'</span>'
	                +'<h5>' + hotel.reviews.categories[i].name +'</h5>'
	                +'<p>';
	        for(var j in hotel.reviews.categories[i].entries){
	        	reviews += '"' + hotel.reviews.categories[i].entries[j] + '", ';
	        }
	        reviews = reviews.replace(/, $/, "") + ".";
	        reviews += '</p> </div>';
	        
	        if (((i%2) - 1) == 0) {
	            reviews += '</div>';
			} 
		}	
	    if (i%2 == 0) {
	        reviews += '</div>';
		}
	}
	else reviews = '<p style="text-align: center;"> Không có nhận xét nào cho khách sạn này. </p>';

	var result = template.replace('{{images_li}}', images_li)
			.replace('{{data-target}}', id)
			.replace(/{{name}}/g, hotel.hotel.name)
			.replace('{{address}}', hotel.hotel.address)
			.replace('{{price}}', numberWithCommas(hotel.price_total))
			.replace('{{stars}}', stars)
			.replace('{{roomtype}}', hotelinput.rooms + ' x ' + hotel.room.type_room)
			.replace('{{amenities}}', amenities)
			.replace('{{reviews}}', reviews)
			.replace('{{description}}', (hotel.hotel.description)? hotel.hotel.description.replace(/\n\n/g, '</p><p>') : "Không có mô tả");

	$('#hoteldetailsmodal .modal-body').html(result);

	var images_corousel = '';
	for(var i in hotel.hotel.image_url) {
          images_corousel += '<div class="item"> <img src="http://' + hotel.hotel.image_url[i].url + '" alt="' + hotel.hotel.name 
      						+ '" class="img-responsive"></div>';
    }
    $('#imageModal .carousel-inner').html(images_corousel.replace('<div class="item">', '<div class="item active"> '));
          
}

function redirectToBook(details, action) {
	$('#book input[name="details"]').val(JSON.stringify(details));
	$('#book').attr('action', action);
	if(!isLogin) {
		$('#loginModal').modal();
	}
	else 
		//if(tourId != "") {
			// $('input[name="tourId"]').val(tourId);
			$('#book').submit();
		// }
		// else {
		// 	tourHandler();
		// }
}


// Tours handler
var t = '';
function tourHandler() {
	var originName = $('#origin-input').val();
	var destinationName = $('#destination-input').val();
	$.ajax({
		url: 'api/v1/postTour',
		method: 'post',
		data: {
			originName: originName,
			destinationName: destinationName,
			startDate: request.outbounddate,
			endDate: (request.inbounddate == '')? nextweek():request.inbounddate,
			adults: request.adults,
			children: request.children,
			infants: request.infants
		}
	}).done(function(data){
		tourId = data.data.id;
		$('input[name="tourId"]').val(tourId);
		$('#book').submit();
	}).fail(function(e){

	})
}

function nextweek(){
    var today = new Date();
    var nextweek = new Date(today.getFullYear(), today.getMonth(), today.getDate()+7);
    return nextweek;
}

getEnityId(request.destinationplace, request.outbounddate, request.inbounddate, request.adults, Math.round(parseInt(request.adults)/2));

$(document).on('click', '#plane', function(){
	routePlane();
})

$('#thingsModal').on('shown.bs.modal', function () {
	$('#thingsModal li.active a').trigger( "click" );
});
$('#thingsModal').on('hidden.bs.modal', function () {
	switch($('#thingsModal li.active a').attr('href')) {
		case '#museum': clearMarkers(museumMarkers); break;
		case '#parks': clearMarkers(parkMarkers); break;
		case '#restaurant': clearMarkers(restaurantMarkers); break;
		case '#other': clearMarkers(otherMarkers); break;
	}
   google.maps.event.clearListeners(map, 'idle');  
  routePlane();
})

var carModalOpen = false, hotelModalOpen = false;

$('#hotelModal').on('hidden.bs.modal', function () {
	hotelModalOpen = false;
  clearMarkers(hotelMarkers);
  routePlane();
})
$('#carModal').on('hidden.bs.modal', function () {
	carModalOpen = false;
  clearMarkers(carMarkers);
  routePlane();
})
$('#hotelModal').on('shown.bs.modal', function () {
	hotelModalOpen = true;
   expandViewportToFitPlace(request.dlat, request.dlng);
   if(hotelMarkers.length > 0)
   	dropMarker(hotelMarkers);

})

$('#carModal').on('shown.bs.modal', function () {
	carModalOpen = false;
   expandViewportToFitPlace(request.dlat, request.dlng);
   if (carMarkers.length > 0) 
   dropMarker(carMarkers);
})



function sortFlights(list, prop, asc = true) {
    var sort_array = [];
	for (var key in list) {
	    sort_array.push({key:key,price:list[key].Price});
	}

	// Now sort it:
	sort_array.sort(function(x,y){return parseFloat(x.price) - parseFloat(y.price)});

	// Now process that object with it:
	for (var i=0;i<sort_array.length;i++) {
	    var item = list[sort_array[i].key];
	    console.log(item);
	    // now do stuff with each item
	}
}

if(request.inbounddate === '') {
	$('#hotelModal .loading').html('<b> Chọn ngày trả phòng trước khi tìm kiếm </b>');
	$('#carModal .loading').html('<b> Chọn ngày trả phòng trước khi tìm kiếm </b>');
}
