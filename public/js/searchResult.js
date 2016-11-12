
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
	}).datepicker("setDate", request.inbounddate);;
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

$('#rooms').val(Math.round((parseInt(request.adults) + parseInt(request.children))/2));
$('#guests').val(parseInt(request.adults) + parseInt(request.children));
$('#moreHotelInfo > span:first-child').text(parseInt(request.adults) + parseInt(request.children) + ' Người, ' + Math.round((parseInt(request.adults) + parseInt(request.children))/2) + ' Phòng');

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
	}).datepicker("setDate", request.outbounddate);

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


// open flight details modal
$(document).on('click', '.details-link', function(e){
	var dom = $(e.target).closest('div[class^="result-item"]');
	renderFlightDetails(dom);
	$('#flightdetailsmodal').modal('show');
});

// hotel details modal
$(document).on('click', '#hotelModal .listing-item', function(e){
	renderHotelDetails($(this).attr('data-id'));
	$('#hoteldetailsmodal').modal('show');
})

$(document).on('click', '.result-item .item-select-button', function(e){
	var dom = $(e.target).closest('div[class^="result-item"]');
	renderFlightDetails(dom);
	redirectToBook(JSON.stringify(createFlightJson()), 'booking/flight');
});

$(document).on('click', '#flightdetailsmodal .item-select-button', function(e){
	redirectToBook(JSON.stringify(createFlightJson()), 'booking/flight');
});

$(document).on('click', '#hoteldetailsmodal #hotelbooking', function(e){
	var details = hoteldetails[$('#hoteldetailsmodal .details').attr('data-target')];
	redirectToBook(details, 'booking/hotel');
});


$(document).on('click', '#flight-search', function(e) {
	getAirPortCode($('#outbounddate').val(), $('#inbounddate').val(),
		 $('#adults').val(), $('#childrens').val(), $('#kid').val(), $('.cabinclass input[name="gender"]:checked').val());
});

$(document).on('click', '#car-search', function(e) {
	Car(destinationAirCode, destinationAirCode, $('#pickupdate-input').val() + 'T' + $('#pickuptime').val(), $('#dropoffdate-input').val() + 'T' + $('#dropofftime').val());
});

$(document).on('click', '#hotel-search', function(e){
	Hotel($('#checkindate').val(), $('#checkoutdate').val(), $('#guests').val(), $('#rooms').val());
})

function renderFlightDetails(dom) {
	var sum = dom.children('.item-summary');
	var i = 2;
	dom.children('.item-details').children('.journey-row').each(function() {
		var logo = $(this).children().children('.flight-logo'),
			origin = $(this).children().children('.origin-place'),
			destination = $(this).children().children('.destination-place'),
			stop = $(this).children().children('.stop-map');

		var row = $('#flightdetailsmodal .details-row:nth-child(' + i + ')').children('.details-content');
		var info_0 = row.children('.content-info').children('.info-cell').eq(0),
			info_1 = row.children('.content-info').children('.info-cell').eq(1),
			info_2 = row.children('.content-info').children('.info-cell').eq(2),
			carrier = row.children('.carrier');

		info_0.children('h4').text(origin.children('.journey-station').text());
		info_0.children('h5').text(origin.children('.journey-time').text());
		info_1.children('h4').text(destination.children('.journey-station').text());
		info_1.children('h5').text(destination.children('.journey-time').text());
		info_2.children('h5').last().text(stop.children('.journey-duration').text());
		carrier.children('.flight-logo').html(logo.html());
		carrier.children('span').text('chưa trả về');

		i++;
	})

	$('#flightdetailsmodal .summary').children('h5').text(sum.children('.summary-details').text());
	$('#flightdetailsmodal .summary').children('.best-price').html(sum.children('.price-select-block').html());
}

// render hotel details
function renderHotelDetails(id) {
	var hotel = hoteldetails[id];
	var template = $('#hotelDetailsTemplate').html();

	var stars = '';
	for(var i = 0; i < 5; i++){
		if(((hotel.hotel.popularity - 20*i)/20) >= 1)
			stars += '<span><i class="fa fa-star" aria-hidden="true"></i></span>';
		else if(((hotel.hotel.popularity - 20*i)/20) >= 0.5)
			stars += '<span><i class="fa fa-star-half-o" aria-hidden="true"></i></span>';
		else 
			stars += '<span><i class="fa fa-star-o" aria-hidden="true"></i></span>';

	}

	var images_li = '';
	for(var i = 0; i < 5; i++){
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
        amenities += '</p> </div>';
        if (((i+1)%3) == 0) {
            amenities += '</div>';
		} 
	}
    if (((i%3) -2) != 0) {
        amenities += '</div>';
	}

	var reviews = '';
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
        reviews += '</p> </div>';
        
        if (((i%2) - 1) == 0) {
            reviews += '</div>';
		} 
	}	
    if (i%2 == 0) {
        reviews += '</div>';
	}

	var result = template.replace('{{images_li}}', images_li)
			.replace('{{data-target}}', id)
			.replace(/{{name}}/g, hotel.hotel.name)
			.replace('{{address}}', hotel.hotel.address)
			.replace('{{price}}', numberWithCommas(hotel.price_total))
			.replace('{{stars}}', stars)
			.replace('{{amenities}}', amenities)
			.replace('{{reviews}}', reviews)
			.replace('{{description}}', hotel.hotel.description.replace(/\n\n/g, '</p><p>'));

	$('#hoteldetailsmodal .modal-body').html(result);

	var images_corousel = '';
	for(var i in hotel.hotel.image_url) {
          images_corousel += '<div class="item"> <img src="http://' + hotel.hotel.image_url[i].url + '" alt="' + hotel.hotel.name 
      						+ '" class="img-responsive"></div>';
    }
    $('#imageModal .carousel-inner').html(images_corousel.replace('<div class="item">', '<div class="item active"> '));
          
}

//  submit post flight
function createFlightJson() {
	var i = 0, jsonObj = [];
	$('#flightdetailsmodal .details-row').each(function() {
		var temp_bound = [];
		$(this).children('.details-content').each(function() {
			var content = $(this).children('.content-info').children('.info-cell');
			var carrier = $(this).children('.carrier');
			var item = {};
			item['origin'] = content.eq(0).children('h4').text();
			item['depart'] = content.eq(0).children('h5').text()
			item['destination'] = content.eq(1).children('h4').text();
			item['arrival'] = content.eq(1).children('h5').text();
			item['carrier_name'] = carrier.children('span').text();
			item['carrier_logo'] = carrier.children().children().attr('src');
			
			temp_bound.push(item);
		});
		if(i == 0) {
			jsonObj.push({outbound: temp_bound});
		} else {
			jsonObj.push({inbound: temp_bound});
		}
		i++;
	});
	jsonObj.push({price: $('#flightdetailsmodal .flight-price span').val()});
	console.log(JSON.stringify(jsonObj));
	return jsonObj;
}

function redirectToBook(details, action) {
	$('#book input[name="details"]').val(JSON.stringify(details));
	$('#book').attr('action', action);
	$.ajax({
		url: 'api/v1/getuser',
		method: 'get'
	}).done(function(status) {
		status.login? $('#book').submit(): $('#loginModal').modal();
	}).fail(function(){
	});
}

// set request date
var outbounddate = new Date(request.outbounddate),
	day = outbounddate.getDate(),
	month = outbounddate.getMonth() + 1,
	year = outbounddate.getFullYear();
	$('#planeModal .depart span').text(day + '/' + month + '/' + year);
	$('#carModal .depart span').text(day + '/' + month + '/' + year);
	$('#hotelModal .depart span').text(day + '/' + month + '/' + year);


if(request.inbounddate != '') {
	var inbounddate = new Date(request.inbounddate),
	day = inbounddate.getDate(),
	month = inbounddate.getMonth() + 1,
	year = inbounddate.getFullYear();
	$('#planeModal .arrival span').text(day + '/' + month + '/' + year);
	$('#carModal .arrival span').text(day + '/' + month + '/' + year);
	$('#hotelModal .arrival span').text(day + '/' + month + '/' + year);
}

