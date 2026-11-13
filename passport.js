// Wait until the page elements are ready before running the script
$(document).ready(function () {
    // Define the function that refreshes the passport totals using AJAX
    function refreshProgress() {
        // Send the selected view to progress PHP using AJAX and receive the updated HTML
        $.get("progress.php", { view: $("#passportContent").attr("data-view") }, function (data) {
            // Check whether the server says the user must log in again
            if (data == "login") {
                // Open the login page when there is no longer a login session
                window.location.href = "login.php";
                // Stop this function before trying to update the page
                return;
            // End this condition loop function or class
            }
            // Replace the passport section with the new HTML returned by PHP
            $("#passportContent").html(data);
            // Update the dashboard experience total from the returned experience count
            $("#experienceCount").html($(".passport-progress").attr("data-experiences"));
            // Update the dashboard total of different cafes visited
            $("#cafeCount").html($(".passport-progress").attr("data-cafes"));
            // Update the dashboard stamp total from the returned stamp count
            $("#stampCount").html($(".passport-progress").attr("data-stamps"));
        // Finish this event handler or AJAX callback
        });
    // End this condition loop function or class
    }

    // Start automatic updates only on pages that contain a passport section
    if ($("#passportContent").length > 0) {
        // Run the refresh function every fifteen thousand milliseconds which is fifteen seconds
        setInterval(refreshProgress, 15000);
    // End this condition loop function or class
    }

    // Run these instructions when the profile pencil button is clicked
    $("#editName").click(function () {
        // Allow the user to type a new name into the name field
        $("#name").prop("readOnly", false);
        // Apply the background colour used when the name is being edited
        $("#name").addClass("name-editing");
        // Place the typing cursor inside the name field
        $("#name").focus();
        // Show the Save Changes button after editing is enabled
        $("#saveProfile").show();
    // Finish this event handler or AJAX callback
    });

    // Check the name when the user submits the profile form
    $("#profileForm").submit(function (event) {
        // Read the entered name and remove spaces from its beginning and end
        var name = $("#name").val().trim();
        // Clear the previous name validation message
        $("#nameMsg").html("");
        // Check whether the user has enabled editing with the pencil button
        if ($("#name").prop("readOnly")) {
            // Prevent the form from being sent in this case
            event.preventDefault();
        // Reject an empty name or a name longer than one hundred characters
        } else if (name == "" || name.length > 100) {
            // Display the allowed name length next to the name field
            $("#nameMsg").html("Please enter a name with 1 to 100 characters.");
            // Prevent the form from being sent in this case
            event.preventDefault();
        // End this condition loop function or class
        }
    // Finish this event handler or AJAX callback
    });
// Finish this event handler or AJAX callback
});
