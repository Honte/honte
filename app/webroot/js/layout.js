$(document).ready(function() {  
	
	$(".round").corner({
			  tl: { radius: 10 },
			  tr: { radius: 10 },
			  bl: { radius: 10 },
			  br: { radius: 10 },
			  antiAlias: true,
			  autoPad: false }
	);
	
	$('#flashMessage').corner({
			  tl: { radius: 5 },
			  tr: { radius: 5 },
			  bl: { radius: 5 },
			  br: { radius: 5 },
			  antiAlias: true,
			  autoPad: false }
	);
	
	$('.round_top').corner({
			  tl: { radius: 5 },
			  tr: { radius: 5 },
			  bl: { radius: 0 },
			  br: { radius: 0 },
			  antiAlias: true,
			  autoPad: false }
	);
	
	$('.round_bottom').corner({
			  tl: { radius: 0 },
			  tr: { radius: 0 },
			  bl: { radius: 5 },
			  br: { radius: 5 },
			  antiAlias: true,
			  autoPad: false }
	);
	
	
	
	if ($('#flashMessage').length > 0) {
		setTimeout(function() { $('#flashMessage').fadeOut("slow"); }, 4000);
	}
	
	$(":input").focus(function() {
		$(":input[class!=form-error]").css("border", "1px solid #d2d2d2");
		$(this).css("border", "1px solid #7a9e2c");
	});
	
});