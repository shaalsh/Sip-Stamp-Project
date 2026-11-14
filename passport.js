$(document).ready(function () {
    // Define the function that refreshes the passport totals using AJAX
    function refreshProgress() {
        // Send the selected view to progress PHP using AJAX and receive the updated HTML
        $.get("progress.php", { view: $("#passportView").val() }, function (data) {
            // Check whether the server says the user must log in again
            if (data == "login") {
                window.location.href = "login.php";
                return;
            }
            // Replace the passport section with the new HTML returned by PHP
            $("#passportContent").html(data);
            $("#experienceCount").html($("#totalExperiences").val());
            $("#cafeCount").html($("#totalCafes").val());
            $("#stampCount").html($("#totalStamps").val());
        });
    }

    if ($("#passportContent").length > 0) {
        // Read the latest totals when this page opens
        refreshProgress();
    }

    // Run these instructions when the profile pencil button is clicked
    $("#editName").click(function () {
        $("#nameDisplay").css("display", "none");
        $("#name").css("display", "block");
        $("#name").addClass("name-editing");
        $("#saveProfile").css("display", "block");
    });

    // Check the name when the user submits the profile form
    $("#profileForm").submit(function (event) {
        var name = $("#name").val().trim();
        $("#nameMsg").html("");
        // Reject an empty name or a name longer than one hundred characters
        if (name == "" || name.length > 100) {
            $("#nameMsg").html("Please enter a name with 1 to 100 characters.");
            event.preventDefault();
        }
    });
});
