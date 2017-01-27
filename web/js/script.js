// function up page show
function upPage(){
	if( $(window).scrollTop() > $(window).height()/3){
		$("#up_page").fadeIn(500);
	}
	else{
		$("#up_page").fadeOut(500);
	}
}

//quantity of products in order
function cart_quantity() {
	$('.catalog_product_quantity .plus').click(function() {
		var plus_input = $(this).closest(".catalog_product_quantity").find('input');
		$(plus_input).val(Number($(plus_input).val())+1);
	});

	$('.catalog_product_quantity .minus').click(function() {
		var minus_input = $(this).closest(".catalog_product_quantity").find('input');
		if (Number($(minus_input).val())>1) {
			$(minus_input).val(Number($(minus_input).val())-1);
		}
	});
}

function update_global_cart(cart_count)
{
	$('.cart_navbar a').text(cart_count + ' шт.');

	if(Number($('.cart_navbar a').text().charAt(0)) > 0){
		$('.cart_navbar a').addClass('active');
	}
	else{
		$('.cart_navbar a').removeClass('active');
	}

}

function update_cart(data)
{
	$('#response').html(data.cart_html);
	update_global_cart(data.cart_count);
	cart_quantity();
	cart_res();
}

function cart_res() {

	$('.order_remove a').on("click", function(e){
		e.preventDefault();
		$.ajax({
			url: '/cart/clear',
			type: 'GET',
			success: function(res){
				if (res) {
					res = JSON.parse(res);
					update_cart(res)
				} else {
					alert('Error! Error!');
				}
			},
			error: function(err){
				alert('Error! ' + err);
			}
		});
	});
		
	$('.one_order_item_remove').on("click", function(e){
		e.preventDefault();
		var id = $(this).data('id');
		$.ajax({
			url: '/cart/del',
			data: {id: id},
			type: 'GET',
			success: function(res){
				if (res) {
					res = JSON.parse(res);
					update_cart(res)
				} else {
					alert('Error! Error!');
				}
			},
			error: function(){
				alert('Error!');
			}
		});
	});

	$('.one_order_item_info input').on("change", function(e){
		e.preventDefault();
		var id = $(this).data('id'),
		qty = $(this).val();
		$.ajax({
			url: '/cart/change',
			data: {id: id, qty: qty},
			type: 'GET',
			success: function(res){
				if (res) {
					res = JSON.parse(res);
					update_cart(res)
				} else {
					alert('Error! Error!');
				}
			},
			error: function(){
				alert('Error!');
			}
		});
	});

	$('.one_order_item_info .plus').on("click", function(e){
		e.preventDefault();
		var id = $(this).closest(".catalog_product_quantity").find('input').data('id'),
		qty = $(this).closest(".catalog_product_quantity").find('input').val();
		$.ajax({
			url: '/cart/change',
			data: {id: id, qty: qty},
			type: 'GET',
			success: function(res){
				if (res) {
					res = JSON.parse(res);
					update_cart(res)
				} else {
					alert('Error! Error!');
				}
			},
			error: function(){
				alert('Error!');
			}
		});
	});

	$('.one_order_item_info .minus').on("click", function(e){
		e.preventDefault();
		var id = $(this).closest(".catalog_product_quantity").find('input').data('id'),
		qty = $(this).closest(".catalog_product_quantity").find('input').val();
		$.ajax({
			url: '/cart/change',
			data: {id: id, qty: qty},
			type: 'GET',
			success: function(res){
				if (res) {
					res = JSON.parse(res);
					update_cart(res)
				} else {
					alert('Error! Error!');
				}
			},
			error: function(){
				alert('Error!');
			}
		});
	});

	if(Number($('.cart_navbar a').text().charAt(0)) > 0){
		$('.cart_navbar a').addClass('active');
	}

	confirm_order();
}


function confirm_order(){
	$('#to_order').on("click", function(e){
		e.preventDefault();
		$.ajax({
			url: '/cart/confirm',
			type: 'POST',
			success: function(res){
				if (res) {
					res = JSON.parse(res);
					update_global_cart(res.cart_count);
					update_cart(res);
				} else {
					$('.google.auth-link').click();
				}
			},
			error: function(){
				alert('Error!');
			}
		});
	});
}



$(window).scroll(upPage);

$(document).ready(function() {

	$('.add_to_cart').on("click", function(e){
		e.preventDefault();
		var id = $(this).data('id'),
		qty = $(this).closest(".catalog_product_footer").find(".qty").val();
		$.ajax({
			url: '/cart/add',
			data: {id: id, qty: qty},
			type: 'GET',
			success: function(res){
				if (res) {
					res = JSON.parse(res);
					update_global_cart(res.cart_count);
				} else {
					alert('Error! Error!');
				}
			},
			error: function(){
				alert('Error!');
			}
		});
	});


	cart_quantity();

	cart_res();

	// confirm_order();

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

	$(".fancybox").fancybox();

});
