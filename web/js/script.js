// function up page 
function upPage(){
	if( $(window).scrollTop() > $(window).height()/3){
		$("#up_page").fadeIn(500);
	}
	else{
		$("#up_page").fadeOut(500);
	}
}


$(document).ready(function() {

	$(window).scroll(upPage);

// up page 
	$('#up_page').click(function() {
    	$('html, body').animate({scrollTop: 0},500);
    	return false;
	});

// only numbers 
	$(".catalog_product_quantity input").keypress(function(e) {
		if ( e.which < 48 || e.which > 57) {
			return false;
		}
	});


	$('.catalog_product_quantity .plus').click(function() {
		var plus_input = $(this).closest(".catalog_product_quantity").find('input');
		$(plus_input).val(Number($(plus_input).val())+1);
	});

	$('.catalog_product_quantity .minus').click(function() {
		var plus_input = $(this).closest(".catalog_product_quantity").find('input');
		if (Number($(plus_input).val())>1) {
			$(plus_input).val(Number($(plus_input).val())-1);
		}
	});


// $('.catalog_product_quantity input').change(function(){
// 	$(this).closest(".catalog_product_quantity").find('.minus').css("border-top", "10px solid rgba(0,0,0,1)");
// });

		

});