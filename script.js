// script.js - JavaScript for the experience pages

// colours the stars when one is clicked:  onclick="chooseStar(4)"
function chooseStar(number) {
    document.getElementById("stars").value = number;
    for (var i = 1; i <= 5; i++) {
        if (i <= number) {
            document.getElementById("star" + i).className = "star on";
        } else {
            document.getElementById("star" + i).className = "star";
        }
    }
}

window.onload = function () {
    var form = document.getElementById("experienceForm");
    if (form == null) {
        return;                                   // this page has no form
    }

    chooseStar(document.getElementById("stars").value);   // edit page: show the saved rating

    // check the form before it is sent
    form.onsubmit = function (e) {
        var valid = true;

        if (document.getElementById("cafe_id").value == "") {
            document.getElementById("cafeMsg").innerHTML = "Please choose a café";
            valid = false;
        } else {
            document.getElementById("cafeMsg").innerHTML = "";
        }

        if (document.getElementById("drink").value == "") {
            document.getElementById("drinkMsg").innerHTML = "Please choose a drink";
            valid = false;
        } else {
            document.getElementById("drinkMsg").innerHTML = "";
        }

        if (document.getElementById("stars").value == 0) {
            document.getElementById("starsMsg").innerHTML = "Please click a star";
            valid = false;
        } else {
            document.getElementById("starsMsg").innerHTML = "";
        }

        if (document.getElementById("comment").value == "") {
            document.getElementById("commentMsg").innerHTML = "Please write a review";
            valid = false;
        } else {
            document.getElementById("commentMsg").innerHTML = "";
        }

        if (valid == false) {
            e.preventDefault();                   // stop the form
        }
    };
};

// jQuery AJAX: click a star on a card -> save the new rating without reloading
$(document).ready(function () {
    $(".rate-star").click(function () {
        var id    = $(this).attr("data-id");
        var stars = $(this).attr("data-stars");

        $.get("rate.php?id=" + id + "&stars=" + stars, function (data) {
            if (data == "ok") {
                $("#exp" + id + " .rate-star").removeClass("on");
                for (var i = 1; i <= stars; i++) {
                    $("#exp" + id + " .rate-star[data-stars='" + i + "']").addClass("on");
                }
                $("#ajaxMessage").html("Rating saved: " + stars + " stars.");
            }
        });
    });
});
