// Get flight list
$.ajax({
	type: 'GET',
	url: 'http://familytravel.com/api/v1/livePriceFlight',
	data: {
		originplace: 'HAN-sky',
		destinationplace: 'SGN-sky',
		outbounddate: $request.outbounddate,
		inbounddate: $request.inbounddate,
		adults: $request.adults,
		children: $request.children,
        infants: $request.infants,
        cabinclass: $request.cabinclass
	},
	success: function (data) {
		var flights = data.data;
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

// Get car list
$.ajax({
	type: 'GET',
	url: 'http://familytravel.com/api/v1/livecarhire',
	data: {
		pickupplace: 'HAN-sky',
		dropoffplace: 'HAN-sky',
		pickupdatetime: $request.outbounddate +'T12:00',
		dropoffdatetime: ($request.inbounddate != '')? $request.inbounddate +'T12:00': (new Date($request.inbounddate)).setDate((new Date($request.inbounddate)).getDate() + 7).getDate() +'T12:00'
	},
	success: function (data) {
		var cars = data.data;
		if(cars.lenght == 0)
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

