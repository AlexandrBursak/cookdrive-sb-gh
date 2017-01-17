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

	$('#up_page').click(function() {
    	$('html, body').animate({scrollTop: 0},500);
    	return false;
	});


});