var clones = [];

function updateOrder(data) {
    $(".photos li").each(function(i, val) {
        $(".photos li").eq(i).children("input:last").val(i);
    });
}

function orderSaved(data) {
    $(".spinner").hide();
    if (data != 0) {
        alert("Wystąpił błąd");
    }
}

function photoSaved(data) {
    $(".spinner").hide();

    if (data < 0) {
        alert("Wystąpił błąd");
    } else {

        var id = data['id'];
        var desc = data['desc'];

        $(".save"+id).parent().parent().children("span").replaceWith(
            '<span>'+desc+'</span>'
        );
        $(".cancel"+id).replaceWith('');
        $(".save"+id).replaceWith(
            '<a href="#" class="edit_photo">edytuj</a>'
        );
        $(".edit_photo").bind("click", edit_click);

    }
}

function photoAdded(data) {
    $(".spinner").hide();
    $("#dialog").dialog('close');
    $("#dialog").replaceWith('');

    if (data['success'] > 0) {
        $(".photos ul").append(data['html']);
        $(".edit_photo").bind('click', edit_click);
        $(".delete").bind('click', delete_click);

    } else {
        alert("Nie dodano zdjęcia");
    }
}

function photoDeleted(data) {
    $(".spinner").hide();

    if (data < 0) {
        alert("Wystąpił błąd");
    } else {
        $("input[value="+data+"]").parent().fadeOut("slow", function() {
            $("input[value="+data+"]").parent().replaceWith('');
        });
    }


}

function save_click() {
    var id = $(this).parent().parent().children("input:first").val();
    var desc = $(this).parent().parent().children("span").children("input").val();

    $(".spinner").show();
    $.post(getRoot("/photos/ajax_edit"), { photo_id : id, photo_desc : desc }, photoSaved, "json" );

    return false;

}

function edit_click() {
    var id = $(this).parent().parent().children("input:first").val();
    clones[id] = $(this).parent().parent().clone(true);
    var desc = $(this).parent().parent().children("span").text();
    $(this).parent().parent().children("span").replaceWith(
            '<span><input type="text" value="'+desc+'" /></span>'
     );
    $(this).replaceWith('<a href="#" class="save'+id+'">zapisz</a><a href="#" class="cancel'+id+'">anuluj</a>');
    $(".save"+id).bind('click', save_click);
    $(".cancel"+id).bind('click', cancel_click);
    return false;
}

function photo_send() {
        $.post(getRoot("/photos/ajax_main_add", { test : "10" }, null, "json"));
        $("#dialog").dialog('close');
}

function dialog(data) {
    $("body").append(data['html']);
    
    $("#dialog").dialog({
            autoOpen: false,
			bgiframe: true,
            width: 400,
			height: 250,
			modal: true,
			buttons: {
				'Dodaj zdjęcie': photo_send,
				'Anuluj': function() {
					$(this).dialog('close');
				}
			}
	});
}

function cancel_click() {
    var id = $(this).parent().parent().children("input:first").val();
    $(this).parent().parent().replaceWith(clones[id]);
    return false;
}

function delete_click() {
    if (confirm("Na pewno usunąć zdjęcie?")) {

        var id = $(this).parent().parent().children("input:first").val();
        $(".spinner").show();

        $.post(getRoot("/photos/ajax_delete"), { photo_id : id }, photoDeleted, "json");

    }
    return false;
}

function init() {
    if ($(".photos li").size() > 0) {

        updateOrder();

        $(".photo_control").append(
            '<a href="#" class="save_order">zapisz kolejność</a>'
        );

        $(".photos li small").append(
            '<a href="#" class="edit_photo">edytuj</a>'
        );

        $(".photos h3").append(
            '<img src="'+getRoot("img/spinner.gif")+'" class="spinner" alt="loading" />'
        );

        $(".photos li").css("cursor", "move");

        $(".photos ul").sortable({
            stop: updateOrder,
            placeholder: 'draggable'
        });

        $(".save_order").click(function() {
            $(".spinner").show();
            $.post(getRoot("/photos/ajax_order"), $("input").serializeArray(), orderSaved, "json");
            return false;
        });

        $(".edit_photo").bind('click', edit_click);
        $(".delete").replaceWith('<a href="#" class="delete">usuń</a>')
        $(".delete").bind('click', delete_click);
        $(".add_photo").bind('click', add_click);


        var id = $("#ArticleId").val();
        $.post(getRoot("/photos/ajax_add"), { article_id : id }, dialog, "json");

    }
}

function add_click() {
    if ($(".photos li").size() < 1) { return true; }
    // $("#dialog").dialog("open");
    // return false;
    return true;
}

$(document).ready(function() { 
    
    init();

});