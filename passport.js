$(document).ready(function () {
    // Define the function that refreshes the passport totals using AJAX
    function refreshProgress() {
        // Send the selected view to progress PHP using AJAX and receive the updated HTML
        $.get("progress.php", { view: $("#passportContent").attr("data-view") }, function (data) {
            // Check whether the server says the user must log in again
            if (data == "login") {
                window.location.href = "login.php";
                return;
            }
            // Replace the passport section with the new HTML returned by PHP
            $("#passportContent").html(data);
            $("#experienceCount").html($(".passport-progress").attr("data-experiences"));
            $("#cafeCount").html($(".passport-progress").attr("data-cafes"));
            $("#stampCount").html($(".passport-progress").attr("data-stamps"));
        });
    }

    if ($("#passportContent").length > 0) {
        // Read the latest totals when the page opens and when the user returns to it
        refreshProgress();
        window.onfocus = refreshProgress;
    }

    // Run these instructions when the profile pencil button is clicked
    $("#editName").click(function () {
        $("#name").prop("readOnly", false);
        $("#name").addClass("name-editing");
        $("#name").focus();
        $("#saveProfile").show();
    });

    // Check the name when the user submits the profile form
    $("#profileForm").submit(function (event) {
        var name = $("#name").val().trim();
        $("#nameMsg").html("");
        if ($("#name").prop("readOnly")) {
            event.preventDefault();
        // Reject an empty name or a name longer than one hundred characters
        } else if (name == "" || name.length > 100) {
            $("#nameMsg").html("Please enter a name with 1 to 100 characters.");
            event.preventDefault();
        }
    });
});
