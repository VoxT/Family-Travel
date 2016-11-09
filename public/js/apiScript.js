// Get flight list
var hotellist = {};
var hoteldetails = {};
var allHotels = {};

function Flight(originplace, destinationplace, outbounddate, inbounddate, adults, children, infants, cabinclass) {
	$('#planeModal .result-list').html('<div class="loading"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><p>Đang tìm kiếm ...</p></div>');

	$.ajax({
		type: 'GET',
		url: '/api/v1/livePriceFlight',
		data: {
			originplace: 'HAN-sky',
			destinationplace: 'SGN-sky',
			outbounddate: outbounddate,
			inbounddate: inbounddate,
			adults: adults,
			children: children,
	        infants: infants,
	        cabinclass: cabinclass
		},
		success: function (data) {
			var flights = data.data;

			if($.isEmptyObject(flights))
				$('#carModal .loading').html('<b> Không có chuyến bay phù hợp!</b>');

			for(var i in flights) {
					$('#planeModal .loading').hide();
					var outbound = flights[i].Outbound;
					var inbound = flights[i].Inbound;
					var template = $('#itemsTemplate').html();
					var outboundTemplate = $('#flightItemTemplate').html();
					var inboundTemplate = $('#flightItemTemplate').html();
					$('#planeModal .result-list').append(template.replace('{{outbound}}', 
											outboundTemplate.replace('{{ImageUrl}}', outbound.ImageUrl).
															replace('{{ImageName}}', outbound.ImageName).
															replace('{{Departure}}', outbound.Departure).
															replace('{{NameOrigin}}', outbound.NameOrigin).
															replace('{{Duration_h}}', outbound.Duration_h).
															replace('{{Duration_m}}', outbound.Duration_m).
															replace('{{Arrival}}', outbound.Arrival).
															replace('{{NameDestination}}', outbound.NameDestination)
											).replace('{{inbound}}', 
											inboundTemplate.replace('{{ImageUrl}}', inbound.ImageUrl).
															replace('{{ImageName}}', inbound.ImageName).
															replace('{{Departure}}', inbound.Departure).
															replace('{{NameOrigin}}', inbound.NameOrigin).
															replace('{{Duration_h}}', inbound.Duration_h).
															replace('{{Duration_m}}', inbound.Duration_m).
															replace('{{Arrival}}', inbound.Arrival).
															replace('{{NameDestination}}', inbound.NameDestination)
											).
											replace('{{price}}', numberWithCommas(flights[i].Price)));			
			}
		},
		error: function () {
			console.log("flight fails");
		}
	});
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
			pickupplace: 'HAN-sky',
			dropoffplace: 'HAN-sky',
			pickupdatetime: pickupdatetime,
			dropoffdatetime: dropoffdatetime
		},
		success: function (data) {
			var cars = data.data;
			if($.isEmptyObject(cars))
				$('#carModal .loading').html('<b> Không có dịch vụ thuê xe phù hợp!</b>');
			for(var i in cars) {
				$('#carModal .loading').hide();
				var item = cars[i];
				var template = $('#carItemTemplate').html();
				$('#carModal .result-list').append(
					template.replace('{{vehicle}}', item.vehicle)
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
function Hotel(entityid, checkindate, checkoutdate, guests, rooms) {
	$('#hotelModal .result-list').html('<div class="loading"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><p>Đang tìm kiếm ...</p></div>');
	$.ajax({
		type: 'GET',
		url: '/api/v1/getlisthotel',
		crossDomain: true,
		contentType: "application/json; charset=utf-8",
		data: {
			entityid: "27546329",
            checkindate: "2016-11-15",
            checkoutdate: "2016-11-18",
            guests: "1",
            rooms: '1'
		},
		success: function (data) {
			$.extend(hotellist, data.data);
			var hotels = data.data;

			for(var hotel_id in hotels) {
				var hotel_param = hotels[hotel_id];
				HotelDetails(hotel_param.url, hotel_id);
			}
			
		},
		error: function () {
			console.log(" hotel fail");
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
			var hotel = hoteldetails[hotel_id];
			var template = $('#hotelItemTemplate').html();

			if($.isEmptyObject(hotellist))
				$('#hotelModal .loading').html('<b> Không có Khách sạn phù hợp!</b>');
			$('#hotelModal .loading').hide();

			var stars = '';
			for(var j = 0; j < 5; j++){
				if(((hotel.hotel.popularity - 20*j)/20) >= 1)
					stars += '<span><i class="fa fa-star" aria-hidden="true"></i></span>';
				else if(((hotel.hotel.popularity - 20*j)/20) >= 0.5)
					stars += '<span><i class="fa fa-star-half-o" aria-hidden="true"></i></span>';
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
		}
	})
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



Flight('HAN-sky', 'SGN-sky', request.outbounddate, request.inbounddate,
		 request.adults, request.children, request.infants, request.cabinclass);

Car('HAN-sky', 'HAN-sky', request.outbounddate+'T12:00', request.inbounddate+'T12:00');

Hotel('', '', '', '', '');