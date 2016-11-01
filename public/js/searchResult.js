
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
	    $('.depart span').text(day + '/' + month + '/' + year);
	    $('#inbounddate').datepicker('option', 'minDate', new Date($('#outbounddate').val()));
	    if($('#inbounddate').val() != '')
      		$('.arrival span').text(day + '/' + month + '/' + year);
	  }
	}).datepicker("setDate", new Date());;
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
	    $('.arrival span').text(day + '/' + month + '/' + year);
	  }
	});
}
outbounddatepicker();
inbounddatepicker();

$('#depart').click(function() {
	$('#outbounddate').show().focus().hide();
})
$('#arrival').click(function() {
	$('#inbounddate').show().focus().hide();
});

$('#moreInfo').popover({
	placement: 'bottom',
	html: true,
	content: $('.popover-flight').html()
});

$(".fadeLeft").on('show.bs.modal', function () {
  setTimeout( function() {
    $(".modal-backdrop").addClass("modal-backdrop-left");
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
	  }
	});
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
	});

$('#dropoffdate').click(function() {
	$('#dropoffdate-input').show().focus().hide();
})
$('#pickupdate').click(function() {
	$('#pickupdate-input').show().focus().hide();
});

// open flight details modal
	$(document).on('click', '.details-link', function(e){
		var dom = $(e.target).closest('div[class^="result-item"]');
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

			i++;
		})

		$('#flightdetailsmodal .summary').children('h5').text(sum.children('.summary-details').text());
		$('#flightdetailsmodal .summary').children('.best-price').html(sum.children('.price-select-block').html())

		$('#flightdetailsmodal').modal('show');
	});
})