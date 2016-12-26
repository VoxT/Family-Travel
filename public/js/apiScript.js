// Get hotel list
var hotellist = {};
var hoteldetails = {};
var hotelinput = {};

// get flight list
var flightlist = {};
var flightinput = {};

var originAirCode = '';
var destinationAirCode = '';

var carList = {};

var entityid = '';

//var tourId = request.tourId;

function Flight(originplace, destinationplace, outbounddate, inbounddate, adults, children, infants, cabinclass) {

	$.ajax({
		type: 'GET',
		url: '/api/v1/livePriceFlight',
		data: {
			originplace: originplace,
			destinationplace: destinationplace,
			outbounddate: outbounddate,
			inbounddate: inbounddate,
			adults: adults,
			children: children,
	        infants: infants,
	        cabinclass: cabinclass
		},
		success: function (data) {
			var flights = data.data.flight;

			if($.isEmptyObject(flights))
				$('#planeModal .loading').html('<b> Không có chuyến bay phù hợp!</b>');

			$.extend(flightinput, data.data.input);
			$.extend(flightlist, flights);
			
			renderFlight(flights);
			FlightIndex(1, data.data.sessionUrl);
		},
		error: function () {
			console.log("flight fails");
		}
	});
}

function FlightIndex(index, url) {
	$.ajax({
		url: 'api/v1/getLivePriceFlightByIndex',
		method: 'get',
		data: {
			index: index,
			url: url
		},
		success: function(data) {
			var flights = data.data.flight;

			if($.isEmptyObject(flights))
				console.log('get flight stop');
			else {
				renderFlight(flights);
				$.extend(flightlist, flights);
				FlightIndex(++index, url);
			}
		},
		error: function() {
			console.log('get flight stop');
		}
	})
}

function renderFlight(data) {
	var flights = data;
	for(var i in flights) {
		$('#planeModal .loading').hide();
		var outbound = flights[i].Outbound.overall;
		var inbound = flights[i].Inbound.overall;
		var template = itemsTemplate;
		var osegment = flights[i].Outbound.segment;
		var dsegment = flights[i].Inbound.segment;

		var ostop = '';
		if(osegment.length > 1) {
			for(var j = 0; j < osegment.length; j++) {
				ostop += '<span class="line-stop">'
						+'<span class="stop-dot" title="' + osegment[j].destinationName + '"></span></span>';
				if((j+2) == osegment.length) break;
			}
		}
		else ostop = '<span class="line-stop"></span>';

		var dstop = '';
		if(dsegment.length > 1) {
			for(var j = 0; j < dsegment.length; j++) {
				dstop += '<span class="line-stop">'
						+'<span class="stop-dot" title="' + dsegment[j].destinationName + '"></span></span>';
				if((j+2) == dsegment.length) break;
			}
		}
		else dstop = '<span class="line-stop"></span>';

		var outboundTemplate = flightItemTemplate;
		var inboundTemplate = flightItemTemplate;
		$('#planeModal .result-list').append(template.replace('{{outbound}}', 
								outboundTemplate.replace('{{ImageUrl}}', outbound.imageUrl).
												replace(/{{ImageName}}/g, outbound.imageName).
												replace('{{Departure}}', outbound.departureTime).
												replace('{{NameOrigin}}', outbound.originName + ' ('+ outbound.originCode + ')').
												replace('{{Duration_h}}', outbound.duration_h).
												replace('{{Duration_m}}', outbound.duration_m).
												replace('{{stop}}', ostop).
												replace('{{Arrival}}', outbound.arrivalTime).
												replace('{{stop_title}}', (osegment.length > 1)? osegment.length - 1 + ' Chặng dừng': 'Bay Thẳng').
												replace('{{NameDestination}}', outbound.destinationName + ' ('+ outbound.destinationCode + ')')
								).replace('{{inbound}}', 
								dsegment.length?
								inboundTemplate.replace('{{ImageUrl}}', inbound.imageUrl).
												replace(/{{ImageName}}/g, inbound.imageName).
												replace('{{Departure}}', inbound.departureTime).
												replace('{{NameOrigin}}', inbound.originName + ' ('+ inbound.originCode + ')').
												replace('{{Duration_h}}', inbound.duration_h).
												replace('{{Duration_m}}', inbound.duration_m).
												replace('{{stop}}', dstop).
												replace('{{stop_title}}', (dsegment.length > 1)? dsegment.length - 1 + ' Chặng dừng': 'Bay Thẳng').
												replace('{{Arrival}}', inbound.arrivalTime).
												replace('{{NameDestination}}', inbound.destinationName + ' ('+ inbound.destinationCode + ')')
								: '')
								.replace('{{price}}', numberWithCommas(flights[i].Price))
								.replace('{{data-id}}', i));			
}
}

// Get car list
function Car(originplace, destinationplace, pickupdatetime, dropoffdatetime) {
	$('#carModal .result-list').html('<div class="loading"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><p>Đang tìm kiếm ...</p></div>');
	$.ajax({
		type: 'GET',
		url: '/api/v1/livecarhire',
		crossDomain: true,
		contentType: "application/json; charset=utf-8",
		data: {
			pickupplace: originplace,
			dropoffplace:  destinationplace,
			pickupdatetime: pickupdatetime,
			dropoffdatetime: dropoffdatetime
		},
		success: function (data) {
			var cars = data.data;
			if($.isEmptyObject(cars))
				$('#carModal .loading').html('<b> Không có dịch vụ thuê xe phù hợp!</b>');

			$.extend(carList, cars);

			for(var i in cars) {
				$('#carModal .loading').hide();
				var item = cars[i];
				var template = carItemTemplate;
				$('#carModal .result-list').append(
					template.replace('{{id}}', i)
							.replace('{{vehicle}}', item.vehicle)
							.replace('{{image_url}}', item.image_url)
							.replace('{{car_class_name}}', item.car_class_name)
							.replace('{{seats}}', item.seats)
							.replace('{{doors}}', item.doors)
							.replace('{{bags}}', item.bags)
							.replace('{{air_conditioning_icon}}', item.air_conditioning ? " fa-check":" fa-times" )
							.replace('{{manual_icon}}', item.manual ? " fa-check":"fa-times").
							replace('{{mandatory_chauffeur_icon}}', item.mandatory_chauffeur ? " fa-check":" fa-times" )
							.replace('{{pick_up_address}}', item.pick_up_address)
							.replace('{{free_cancellation_icon}}', item.free_cancellation ? " fa-check-circle ":" fa-times-circle")
							.replace('{{theft_protection_insurance_icon}}', item.theft_protection_insurance ? " fa-check-circle ":" fa-times-circle")
							.replace('{{free_collision_waiver_insurance_icon}}', item.free_collision_waiver_insurance ? " fa-check-circle ":" fa-times-circle")
							.replace('{{free_breakdown_assistance_icon}}', item.free_breakdown_assistance ? " fa-check-circle ":" fa-times-circle")
							.replace('{{fuel_policy}}', (item.fuel_policy === "full_to_full")? "":"Không ")
							.replace('{{price_all_days}}', numberWithCommas(item.price_all_days))
					)
			}
		},
		error: function () {
			console.log(" car fail");
		}
	})
}
// Get hotel list
function Hotel(checkindate, checkoutdate, guests, rooms) {
	$('#hotelModal .result-list').html('<div class="loading"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><p>Đang tìm kiếm ...</p></div>');
	$.ajax({
		type: 'GET',
		url: '/api/v1/getlisthotel',
		crossDomain: true,
		contentType: "application/json; charset=utf-8",
		data: {
			entityid: entityid,
            checkindate: checkindate,
            checkoutdate: checkoutdate,
            guests: guests,
            rooms: rooms
		},
		success: function (data) {
			$.extend(hotellist, data.data.Hotels);
			hotelinput = {checkindate: checkindate, checkoutdate: checkoutdate, guests: guests, rooms: rooms};
			var hotels = data.data.Hotels;

			for(var hotel_id in hotels) {
				var hotel_param = hotels[hotel_id];
				HotelDetails(hotel_param.url, hotel_id);
			}
			HotelIndex(1, data.data.SessionUrl);
			
		},
		error: function () {
			console.log(" hotel fail");
		}
	})
}

function HotelIndex(index, url) {
	console.log(index+ ' - ');
	$.ajax({
		url: 'api/v1/getHotelListByIndex',
		method: 'get',
		data: {
			url: url,
			index: index
		},
		success: function(data) {
			var hotels = data.data.Hotels;
			$.extend(hotellist, hotels);

			for(var hotel_id in hotels) {
				var hotel_param = hotels[hotel_id];
				HotelDetails(hotel_param.url, hotel_id);
			}

			HotelIndex(++index, url);
		},
		error: function(e){
			console.log('get hotel stop')
		}
	})
}

function HotelDetails(url, hotel_id) {
	$.ajax({
		type: 'GET',
		url: '/api/v1/gethoteldetails',
		crossDomain: true,
		contentType: "application/json; charset=utf-8",
		data: {
			url: url,
			hotel_id: hotel_id
		},
		success: function (data) {			
			$.extend(hoteldetails, data.data);

			var myLatLng = {lat: hoteldetails[hotel_id].hotel.latitude, lng: hoteldetails[hotel_id].hotel.longitude};
	   		var marker = new google.maps.Marker({
			    position: myLatLng,
			    map: map,
			    hotel_id: hotel_id,
			    icon: 'http://maps.google.com/mapfiles/ms/icons/blue.png',
			    title: 'Hotel!'
			  });
	   		marker.setMap(null);
	   		hotelMarkers.push(marker);
	   		
			renderHotel(hotel_id);
		}
	})
}

function renderHotel(hotel_id) {

	var hotel = hoteldetails[hotel_id];
			var template = hotelItemTemplate;

			if($.isEmptyObject(hotellist))
				$('#hotelModal .loading').html('<b> Không có Khách sạn phù hợp!</b>');
			$('#hotelModal .loading').hide();

			var stars = '';
			for(var j = 1; j <= 5; j++){
				if(j <= hotel.hotel.star_rating)
					stars += '<span><i class="fa fa-star" aria-hidden="true"></i></span>';
				else 
					stars += '<span><i class="fa fa-star-o" aria-hidden="true"></i></span>';

			}
			$('#hotelModal .result-list').append(
					template.replace('{{id}}', hotel_id)
							.replace('{{image}}', hotel.hotel.image_url[0].url)
							.replace(/{{name}}/g, hotel.hotel.name)
							.replace('{{address}}', hotel.hotel.address)
							.replace('{{price}}', numberWithCommas(hotel.price_total))
							.replace('{{popularity}}', hotel.hotel.popularity)
							.replace('{{review}}', hotel.reviews.reviews_count)
							.replace('{{stars}}', stars)
				);

	var marker_num = hotelMarkers.length - 1;
	$('.listing-item[data-id="'+ hotel_id + '"]').attr('onmouseover', 'HotelHoverMaker('+marker_num+')');
	$('.listing-item[data-id="'+ hotel_id + '"]').attr('onmouseout', 'HotelUnHoverMaker('+marker_num+')');
	
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function getRigion() {
		
	$.ajax({
		type: 'GET',
		url: 'http://terminal2.expedia.com/x/mhotels/search',
		data: {
			city: 'H%E1%BB%93+Ch%C3%AD+Minh',
			apikey: 't3a2uaYi1iePqNh3DVuhEX8UqUQGPZT1',
			checkInDate: '2016-11-01',
			checkOutDate: '2016-11-03',
			room: '2,12'
		},
		success: function (data) {
			console.log(JSON.stringify(data));
		}
	});

}


// Rome to rio
function getAirPortCode(outbounddate, inbounddate,
					 adults, children, infants, cabinclass, car = false) {
	$('#planeModal .result-list').html('<div class="loading"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><p>Đang tìm kiếm ...</p></div>');
	$.ajax({
		type: 'GET',
		url: 'http://free.rome2rio.com/api/1.4/json/Search',
		crossDomain: true,
		data: {
			oPos: olat + ', ' + olng,
			dPos: dlat + ', ' + dlng,
			key: '5GMByjBa'
		},
		success: function (data) {		
			var places = data.places;
			var routes = data.routes;
			var depPlace = '';
			var arrPlace = '';
			var breakable = false;

			for(var i in routes){
				var item = routes[i];
				if((item.name.indexOf("fly") !== -1) || (item.name.indexOf("Fly") !== -1) ){
					var segments = item.segments;
					for(var j in segments){
						if(segments[j].segmentKind === "air"){
							depPlace = segments[j].depPlace;
							arrPlace = segments[j].arrPlace;
							breakable = true;
							break;
						}
					}
				}
				if(breakable) break;
			}

			originAirCode = places[depPlace].code;
			destinationAirCode = places[arrPlace].code;

			flightPlanCoordinates = [{lat: places[depPlace].lat, lng: places[depPlace].lng},
									{lat: places[arrPlace].lat, lng: places[arrPlace].lng}
									];
			
			Flight(originAirCode + '-sky', destinationAirCode + '-sky', outbounddate, inbounddate,
					 adults, children, infants, cabinclass);

		},
		fail: function(e) {

		}
	});

}
getAirPortCode(request.outbounddate, request.inbounddate,
					 request.adults, request.children, request.infants, request.cabinclass, true);


function getEnityId(destinationplace, checkindate, checkoutdate, guests, rooms) {
	$.ajax({
		url: '/api/v1/getEnityId',
		method: 'GET',
		data: {
			queryText: encodeURI(destinationplace)
		}
	}).done(function(data){

		var list = data.data.parsed.results;
		for(var i in list) {
			if((list[i].geo_type === 'City') ||(list[i].geo_type === 'SecondLevelNationAdministrativeDivision')) {
				entityid = list[i].individual_id; break;
			}
		}
		if(entityid !== '') {
			Hotel(checkindate, checkoutdate, guests, rooms);
			Car(entityid, entityid, request.outbounddate+'T12:00', request.inbounddate+'T12:00');
		}
	}).fail(function (e) {
		
	})
}


function HotelHoverMaker(marker_num) {
	hotelMarkers[marker_num].setIcon('/images/icons/art.png');
}

function HotelUnHoverMaker(marker_num) {
	hotelMarkers[marker_num].setIcon('http://maps.google.com/mapfiles/ms/icons/blue.png');
}