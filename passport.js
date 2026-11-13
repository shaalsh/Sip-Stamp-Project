$(document).ready(function () {
    // Get the latest stamp count from PHP and update this section without reloading the page (AJAX)
    function refreshProgress() {
        $.get("progress.php", { view: $("#passportContent").attr("data-view") }, function (data) {
            if (data == "login") {
                window.location.href = "login.php";
                return;
            }
            $("#passportContent").html(data);
            $("#experienceCount").html($(".passport-progress").attr("data-experiences"));
            $("#cafeCount").html($(".passport-progress").attr("data-cafes"));
            $("#stampCount").html($(".passport-progress").attr("data-stamps"));
        });
    }

    // Check for new stamps every 15 seconds while the dashboard or passport is open
    if ($("#passportContent").length > 0) {
        setInterval(refreshProgress, 15000);
    }

    // Profile: click the pencil to edit the name (the email stays fixed)
    $("#editName").click(function () {
        $("#name").prop("readOnly", false);
        $("#name").addClass("name-editing");
        $("#name").focus();
        $("#saveProfile").show();
    });

    // Profile: check the name before the form is sent
    $("#profileForm").submit(function (event) {
        var name = $("#name").val().trim();
        $("#nameMsg").html("");
        if ($("#name").prop("readOnly")) {
            event.preventDefault();
        } else if (name == "" || name.length > 100) {
            $("#nameMsg").html("Please enter a name with 1 to 100 characters.");
            event.preventDefault();
        }
    });
});
