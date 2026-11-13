// cafes.js - simple search and favorite buttons (JavaScript + jQuery AJAX)
$(document).ready(function () {
    // Search without refreshing the page
    $("#cafeSearch").keyup(function () {
        var search = $("#cafeSearch").val().toLowerCase();
        var cafes = document.getElementsByClassName("cafe-item");
        var count = 0;
        for (var i = 0; i < cafes.length; i++) {
            var text = cafes[i].getAttribute("data-search").toLowerCase();
            if (text.indexOf(search) != -1) {
                $(cafes[i]).show();
                count++;
            } else {
                $(cafes[i]).hide();
            }
        }
        if (count == 0) {
            $("#noCafes").show();
        } else {
            $("#noCafes").hide();
        }
    });

    // Save or remove a favorite using AJAX
    $(".favorite-btn").click(function () {
        var button = $(this);
        var cafeId = button.attr("data-cafe");
        $.ajax({
            url: "toggle_favorite.php",
            type: "POST",
            data: { cafe_id: cafeId },
            success: function (reply) {
                reply = reply.trim();
                if (reply == "added") {
                    button.html("♥ Remove Favorite");
                    $("#favoriteMessage").html("Added to favorites!");
                } else if (reply == "removed") {
                    button.html("♡ Add Favorite");
                    $("#favoriteMessage").html("Removed from favorites.");
                    if (button.attr("data-page") == "favorites") {
                        $("#cafe" + cafeId).hide();
                    }
                } else {
                    $("#favoriteMessage").html("Please log in again.");
                }
            },
            error: function () {
                $("#favoriteMessage").html("Something went wrong. Try again.");
            }
        });
    });
});
