$.ajax({
	type: 'GET',
	url: '/api/v1/livePriceFlight',
	data: {
		originplace: 'HAN-sky',
		destinationplace: 'SGN-sky',
		outbounddate: '2016-10-27',
		inbounddate: '2016-10-28',
		adults: 1
	},
	success: function (data) {
		var flights = data.data;
		for(var i in flights) {
				$('.loading').hide();
				var outbound = flights[i].Outbound;
				var inbound = flights[i].Inbound;
				var template = $('#flightTemplate').html();
				var outboundTemplate = $('#flightItemTemplate').html();
				var inboundTemplate = $('#flightItemTemplate').html();
				$('.result-list').append(template.replace('{{outbound}}', 
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
										replace('{{price}}', flights[i].Price));			
		}
	}
});
