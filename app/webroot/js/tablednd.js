function changeOrder() {
	var new_order = '';
	var rows = $("#ladder_table").children("tbody").children("tr");
		
		for (i=0; i < rows.length; i++) {
			
			new_order += rows.eq(i).attr("name") + " ";
			rows.eq(i).children("td:first").text(i+1);
			
		}
	
	$("#LadderOrder").val(new_order);
	}

$(document).ready(function() { 
	
	$("#ladder_table").tableDnD({
		onDragClass: "drag_class",
	    onDrop: changeOrder
	});
	
	$("#debugLadder").click(function() {
		alert($("#LadderOrder").val());
	});
	
	$(".add").click(function() {
		var current = $(this).parent().parent();
		var last_tr = $("#ladder_table").children().children("tr:last");
		new_tr = last_tr.clone(true).insertAfter(last_tr).hide();
		
		new_tr.attr("name", current.attr("name"));
		new_tr.children("td").eq(1).text(current.children("td").eq(1).text());
		new_tr.fadeIn("fast");
		
		current.removeClass('normal').addClass('hidden');
		
		changeOrder();
		return false;
	});
	
	$(".remove").click(function() {
		var element = $(this).parent().parent();
		element.fadeOut("fast", 
			function() { 
				$("#ladder_players").children().children("tr[name="+element.attr("name")+"]").removeClass('hidden').addClass('normal');
				element.remove(); 
				changeOrder();
			});
		return false;
	});
	
});