/* function hideall() {
	for (i = 1; i < 5; i++)  {
		$("#nav_"+i).hide();
		$("a.nav").parent().removeClass("hover");
	}
}

$(document).ready(function() { 
	$("a.nav").click(function() {
		hideall();
		$("#"+$(this).attr("rel")).show();
		$(this).parent().addClass("hover");
        return false;
	});

    $("#navbar li").mouseover(function() {
       $(this).children("a:first").removeClass("only").addClass("not-only");
       $(this).children(".roll").show();
    }).mouseout(function() {
       $(this).children("a:first").removeClass("not-only").addClass("only");
       $(this).children(".roll").hide();
    });

});
*/