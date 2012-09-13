$(document).ready(function(){
	$('#book').turn({
		autoCenter : true	
	});
	
	$('#book').bind('turning', function(event, pageObject, corner){
		if (pageObject == 4) {
			$('.p2').addClass('fixed');
		}
		if (pageObject == 3) {
			$('.p2').removeClass('fixed');
		}
		
		if (pageObject == $('#book').turn('pages')-3) {
			$('.beforelast').addClass('fixed');
		}
		
		if (pageObject == $('#book').turn('pages')-2) {
			$('.beforelast').removeClass('fixed');
		}
		
		if(pageObject <= 40)		
			$('.page-depth-left').width((pageObject-4)/2)
		
		if(pageObject >= $('#book').turn('pages')-40)		
			$('.page-depth-right').width(($('#book').turn('pages')-pageObject-4)/2)
		
		
	});
});