		"use strict";

		$(document).ready(function() {
    		var paymentType = jQuery('#payment_type').val();
        	if (paymentType == 15) {
          		$('.stripe-payment-method-div').show('slow');
        	} else {
          		$('.stripe-payment-method-div').hide('slow');
        	}
    	});

    	var stripe = Stripe(stripeKey);
      	var elements = stripe.elements();
      	var card = elements.create('card');
      	card.mount('#card-element');
      	
      	jQuery(document).on('change', '#payment_type', function () {
      		var paymentType = jQuery('#payment_type').val();
        	if (paymentType == 15) {
          		$('.stripe-payment-method-div').show('slow');
        	} else {
          		$('.stripe-payment-method-div').hide('slow');
        	}
      	});

      	var form = document.getElementById('payment-form');
	    form.addEventListener('submit', function (event) {
		    event.preventDefault();
		    var paymentType = jQuery('#payment_type').val();
		    if (paymentType == 15) {
		        stripe.createToken(card).then(function (result) {
		            if (result.error) {
		              	var errorElement = document.getElementById('card-errors');
		              	errorElement.textContent = result.error.message;
		            } else {
		              	stripeTokenHandler(result.token);
		            }
		        });
		    } else {
		        form.submit();
		    }
	    });

      	function stripeTokenHandler(token) {
	        var form = document.getElementById('payment-form');
	        var hiddenInput = document.createElement('input');
	        hiddenInput.setAttribute('type', 'hidden');
	        hiddenInput.setAttribute('name', 'stripeToken');
	        hiddenInput.setAttribute('value', token.id);
	        form.appendChild(hiddenInput);
	        form.submit();
      	}