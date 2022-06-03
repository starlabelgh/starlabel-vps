$(document).on('change', '.quantity-change', function() {
	'use strict';
	let quantity 	= $(this).val();
	let rowId 		= $(this).attr('id');
	

	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

	$.ajax({
		url: url,
		type: 'POST',
		dataType: 'html',
		data: { "rowId" : rowId, "quantity" : quantity, "deliveryCharge" : deliveryCharge },
		success: function(data) {
			let response = JSON.parse(data);
			if(response.status) {
				$('.price-'+rowId).text(response.price);
				$('.total-price-js').text(response.totalPrice);
				$('.total-js').text(response.total);
			}
		}
	});
});		