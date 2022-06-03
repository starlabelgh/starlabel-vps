// jquery ready start
$(document).ready(function() {
    /////////////////  items slider. /plugins/slickslider/
    if ($('.slider-banner-slick').length > 0) { // check if element exists
        $('.slider-banner-slick').slick({
            infinite: true,
            autoplay: true,
            slidesToShow: 1,
            dots: false,
            prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-chevron-left"></i></button>',
            nextArrow: '<button type="button" class="slick-next"><i class="fa fa-chevron-right"></i></button>',
        });
    } // end if

	//////////////////////// Prevent closing from click inside dropdown
    $(document).on('click', '.dropdown-menu', function (e) {
      e.stopPropagation();
    });

    $('.js-check :radio').change(function () {
        var check_attr_name = $(this).attr('name');
        if ($(this).is(':checked')) {
            $('input[name='+ check_attr_name +']').closest('.js-check').removeClass('active');
            $(this).closest('.js-check').addClass('active');
           // item.find('.radio').find('span').text('Add');

        } else {
            item.removeClass('active');
            // item.find('.radio').find('span').text('Unselect');
        }
    });


    $('.js-check :checkbox').change(function () {
        var check_attr_name = $(this).attr('name');
        if ($(this).is(':checked')) {
            $(this).closest('.js-check').addClass('active');
           // item.find('.radio').find('span').text('Add');
        } else {
            $(this).closest('.js-check').removeClass('active');
            // item.find('.radio').find('span').text('Unselect');
        }
    });

	//////////////////////// Bootstrap tooltip
	if($('[data-toggle="tooltip"]').length>0) {  // check if element exists
		$('[data-toggle="tooltip"]').tooltip()
	} // end if


}); 
// jquery end

function myFunction(imgs) {
    // Get the expanded image
    var mainthumnail = document.getElementById("mainthumnail");
    // // Use the same src in the expanded image as the image being clicked on from the grid
    console.log(imgs.src);
    mainthumnail.src = imgs.src;
}


function printDiv(divID) {
  'use strict';
  let divElements = document.getElementById(divID).innerHTML;
  let oldPage     = document.body.innerHTML;
  document.body.innerHTML = "<html><head><title></title></head><body>" + divElements + "</body>";
  window.print();
  document.body.innerHTML = oldPage;
  window.location.reload();
}


function currencyFormat(n, currency) {
  return currency + n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
}

$('.variations').on('click', function() {
    var totalAmount     = 0;
    var variationsPrice = parseFloat($(this).data('price'));

    var optionsPrice = 0;
    $('.options').children().each(function(i, j) {
        if ($(this).is(':checked')) {
            optionsPrice += parseFloat($(this).parent().data('price'));
        }
    });

    totalAmount = variationsPrice + optionsPrice;
    var currency_code  = $('#productPrice').data('currency-code');
    $('#productPrice').text(currencyFormat(totalAmount, currency_code));

});

$('.options').on('change', function() {
    var totalAmount     = 0;

    if(parseInt($('.variations.active').data('price'))) {
        var variationsPrice = parseFloat($('.variations.active').data('price'));
    } else {
        var variationsPrice  = parseFloat($('#productPrice').data('unit-price'));
    }

    console.log(typeof(variationsPrice));

    var optionsPrice = 0;
    $('.options').children().each(function(i, j) {
        if ($(this).is(':checked')) {
            optionsPrice += parseFloat($(this).parent().data('price'));
        }
    });

    totalAmount = variationsPrice + optionsPrice;
    
    var currency_code  = $('#productPrice').data('currency-code');
    $('#productPrice').text(currencyFormat(totalAmount, currency_code));
});


$(document).on('change', '.search-location', function() {
    "use strict";
    let location = $(this).val();

    $.ajax({
        url: areaUrl,
        type: 'POST',
        dataType: 'html',
        data: { "id" : location },
        success: function(data) {
            $('.search-area').html(data);
        }
    });
});