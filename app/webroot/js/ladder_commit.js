$(document).ready(function() { 
    
    $("#LadderGamesDatePlayed").datepicker({
        dateFormat: 'yy-mm-dd'
    });

    WinnerStatus();
    TypeStatus();
    BadukStatus();

    $("#LadderGamesWinner").change(function() {
        WinnerStatus();
        TypeStatus();
    });

    $("#LadderGamesType").change(function() {
        WinnerStatus();
        TypeStatus();
    });

    $("#LadderGamesBaduk").click(function() {
        BadukStatus();
    });

    function WinnerStatus() {
        $(".result span").css("display","none");
        $(".result small").css("display","none");
        $("#LadderGamesType").css("display", "none");
        $("#LadderGamesResult").css("display", "none");
        if ($("#LadderGamesWinner").val() < 2) {
            $(".result span").css("display","");
            $("#LadderGamesType").css("display", "");
            $("#LadderGamesType").focus();
        }
    }

    function TypeStatus() {
        $("#LadderGamesResult").css("display", "none");
        if ($("#LadderGamesType").val() == 0 && $("#LadderGamesWinner").val() < 2) {
            $("#LadderGamesResult").css("display", "");
            $(".result small").css("display","");
            $("#LadderGamesResult").focus();
        }
    }

    function BadukStatus() {
        $("#LadderGamesBadukId").parent().css("display", "none")
        $("#LadderGamesUrl").parent().css("display", "none");
        if ($("#LadderGamesBaduk").attr("checked") == true) {
            $("#LadderGamesBadukId").parent().css("display", "");
        } else {
            $("#LadderGamesUrl").parent().css("display", "");
        }
    }
});