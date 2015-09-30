function showStone() {
    if ($(this).attr("rel") != 'clicked') {
        $(this).html('<img alt="white" src="'+getRoot("img/white.png")+'" />');
        $(this).children("img").css("opacity", "0.6");
    }
}

function hideStone() {
    if ($(this).attr("rel") != 'clicked') {
        $(this).children("img").remove();
    }
}

function clickStone() {
    if ($(this).attr("rel") != 'clicked') {
        $(this).attr("rel", "clicked");
        $(this).css("cursor", "");
        $(this).children("img").css("opacity", "1.0");

        if ($(this).attr("id") == "gogrid-32") {
            $("#gogrid-22").children("img").fadeOut("slow", function() { 
                $("gogrid-22").children("img").remove()
                $(".learn a").html('<strong>Prawda, że proste!?</strong><span>Znasz już zasady - naucz się grać przy pomocy interaktywnego kursu Go.</span>');
                $(".learn a").children("strong").css("color", "#900");
                $("#hint").remove();
            })
        } else {
            $("#hint").text("prawie...");
        }
    }
}

$(document).ready(function() {

    $("#gogrid-11, #gogrid-13, #gogrid-31, #gogrid-32, #gogrid-33").attr("rel", "notyet")
    $("#gogrid-11, #gogrid-13, #gogrid-31, #gogrid-32, #gogrid-33").css("cursor", "pointer")
    $("#gogrid-11, #gogrid-13, #gogrid-31, #gogrid-32, #gogrid-33").hover(showStone, hideStone);
    $("#gogrid-11, #gogrid-13, #gogrid-31, #gogrid-32, #gogrid-33").click(clickStone);
    $(".learn").append('<span id="hint">&lArr; sprawdź się</span>');

});
