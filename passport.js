$(document).ready(function () {
    // Load or hide the passport stamps when the dashboard link is clicked
    $("#viewPassport").click(function (event) {
        event.preventDefault();
        var view = "passport";
        if ($("#passportView").val() == "passport") {
            view = "dashboard";
        }

        // Request the selected passport view without reloading the dashboard
        $.get("progress.php", { view: view }, function (data) {
            if (data == "login") {
                window.location.href = "login.php";
                return;
            }
            $("#passportContent").html(data);
            $("#experienceCount").html($("#totalExperiences").val());
            $("#cafeCount").html($("#totalCafes").val());
            $("#stampCount").html($("#totalStamps").val());
            $("#passportView").val(view);
            if (view == "passport") {
                $("#viewPassport").html("Hide Passport");
            } else {
                $("#viewPassport").html("View Passport");
            }
        });
    });

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
