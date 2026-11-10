$(document).ready(function () {
    var content = $("#passportContent");
    var loading = false;

    // Get the latest stamp count from PHP and update this section without reloading the page
    function refreshProgress() {
        if (loading || content.length === 0) {
            return;
        }
        loading = true;
        $.get("progress.php", { view: content.attr("data-view") }, function (data) {
            content.html(data);
            var progress = content.find(".passport-progress");
            $("#experienceCount").text(progress.attr("data-experiences"));
            $("#cafeCount").text(progress.attr("data-cafes"));
            $("#stampCount").text(progress.attr("data-stamps"));
            $("#progressMessage").text("");
        }).fail(function () {
            $("#progressMessage").text("Could not update your stamps. We will try again automatically.");
        }).always(function () {
            loading = false;
        });
    }

    // Check for new stamps while the page is open
    if (content.length > 0) {
        setInterval(function () {
            if (!document.hidden) {
                refreshProgress();
            }
        }, 15000);

        // Update the stamps when the user comes back after adding an experience in another tab
        $(window).on("focus", refreshProgress);
        $(document).on("visibilitychange", function () {
            if (!document.hidden) {
                refreshProgress();
            }
        });
    }

    // Allow the name to be edited after clicking the pencil while the email stays fixed
    var profileForm = $("#profileForm");
    if (profileForm.length > 0) {
        var editing = profileForm.attr("data-editing") === "true";
        $("#name").prop("readOnly", !editing);
        $("#name").toggleClass("name-editing", editing);
        $("#saveProfile").prop("hidden", !editing);
        $("#editName").prop("hidden", false);
    }

    $("#editName").click(function () {
        $("#name").prop("readOnly", false).addClass("name-editing").focus();
        $("#saveProfile").prop("hidden", false);
    });

    profileForm.on("submit", function (event) {
        if ($("#name").prop("readOnly")) {
            event.preventDefault();
            return;
        }
        var valid = true;
        var name = $("#name").val().trim();
        $("#nameMsg").text("");
        if (name === "" || name.length > 100) {
            $("#nameMsg").text("Please enter a name with 1 to 100 characters.");
            valid = false;
        }
        if (!valid) {
            event.preventDefault();
        }
    });
});
