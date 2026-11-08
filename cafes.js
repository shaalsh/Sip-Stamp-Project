// cafes.js - simple search and favorite buttons (JavaScript + jQuery AJAX)
$(document).ready(function () {
    // Search without refreshing the page
    $("#cafeSearch").on("keyup", function () {
        var search = $(this).val().toLowerCase();
        var count = 0;
        $(".cafe-item").each(function () {
            var matches = $(this).attr("data-search").indexOf(search) !== -1;
            $(this).toggle(matches);
            if (matches) count++;
        });
        $("#noCafes").toggle(count === 0);
    });

    // Save or remove favorite using AJAX
    $(".favorite-btn").click(function () {
        var button = $(this);
        $.post("toggle_favorite.php", { cafe_id: button.attr("data-cafe") }, function (reply) {
            if (reply.trim() === "added") {
                button.text("♥ Remove Favorite");
                $("#favoriteMessage").text("Added to favorites!");
            } else if (reply.trim() === "removed") {
                button.text("♡ Add Favorite");
                $("#favoriteMessage").text("Removed from favorites.");
                if (window.location.pathname.indexOf("favorites.php") !== -1) {
                    button.closest(".cafe-item").remove();
                }
            }
        }).fail(function () { $("#favoriteMessage").text("Something went wrong. Try again."); });
    });
});
