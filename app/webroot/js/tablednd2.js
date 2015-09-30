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
	
	var no_files = 0;
	
	$("#gallery_table").tableDnD({
		onDragClass: "drag_class",
	    //onDrop: changeOrder
	});
	
	$("#PhotoFilename").change(function() {
		
		var new_file = $("#PhotoFilename").parent().clone(true).insertAfter($(this).parent());
		
		new_file.children("input").attr("id", "PhotoFilename"+no_files++);
		new_file.children("input").attr("name", "data[Photo][Photos]["+no_files+"][Photo][filename]");
		
	});
	
	$("#PhotoAdminAddForm").submit(function() {
		// return false;
	});
	
});