// function up page show
function upPage(){
	if( $(window).scrollTop() > $(window).height()/3){
		$("#up_page").fadeIn(500);
	}
	else{
		$("#up_page").fadeOut(500);
	}
}

$(window).scroll(upPage);

$(document).ready(function() {

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

//quantity of products in order
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

	$('.order_remove a').on("click", function(e){
		e.preventDefault();
		$.ajax({
			url: '/cart/clear',
			type: 'GET',
			success: function(res){
				if (!res) alert('Error! Error!');
				location.reload();
			},
			error: function(){
				alert('Error!');
			}
		});
	});

	$('.add_to_cart').on("click", function(e){
		e.preventDefault();
		var id = $(this).data('id'),
		qty = $(this).closest(".catalog_product_footer").find(".qty").val();
		$.ajax({
			url: '/cart/index',
			data: {id: id, qty: qty},
			type: 'GET',
			success: function(res){
				if (!res) alert('Error! Error!');
				location.reload();
			},
			error: function(){
				alert('Error!');
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
				if (!res) alert('Error! Error!');
				location.reload();
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
				if (!res) alert('Error! Error!');
				location.reload();
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
				if (!res) alert('Error! Error!');
				location.reload();
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
				if (!res) alert('Error! Error!');
				location.reload();
			},
			error: function(){
				alert('Error!');
			}
		});
	});
// $('.catalog_product_quantity input').change(function(){
// 	$(this).closest(".catalog_product_quantity").find('.minus').css("border-top", "10px solid rgba(0,0,0,1)");
// });
	
		

});


$(window).load(function () {
	if(Number($('.cart_navbar a').text().charAt(0)) > 0){
		$('.cart_navbar a').addClass('active').css('color', '#fff');
	}
});