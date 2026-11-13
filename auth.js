$(document).ready(function () {
    // Send the sign up form without opening the PHP response as a page
    $("#signupForm").on("submit", function (event) {
        event.preventDefault();
        var form = $(this);
        var result = $("#signupMsg");
        var password = $("#password").val();
        var confirmPassword = $("#confirmPassword").val();
        result.removeClass("success failure").text("");

        if (password.length < 8) {
            result.addClass("failure").text("Password must be at least 8 characters.");
            return;
        }
        if (password !== confirmPassword) {
            result.addClass("failure").text("Passwords do not match.");
            return;
        }

        form.find("button[type='submit']").prop("disabled", true);
        $.ajax({
            url: "register.php",
            type: "POST",
            data: {
                name: $("#name").val().trim(),
                email: $("#email").val().trim(),
                password: password,
                confirmPassword: confirmPassword
            },
            success: function (response) {
                // Read the status and message returned by PHP
                var parts = response.split("|");
                if (parts[0] === "success") {
                    result.addClass("success").text(parts[1]);
                    form[0].reset();
                } else {
                    result.addClass("failure").text(parts[1] || "Unable to create your account.");
                }
            },
            error: function (xhr) {
                result.addClass("failure").text("AJAX error: " + xhr.status + ". Please try again.");
            },
            complete: function () {
                form.find("button[type='submit']").prop("disabled", false);
            }
        });
    });

    // Keep login errors inside the form and open the dashboard only after success
    $("#loginForm").on("submit", function (event) {
        event.preventDefault();
        var form = $(this);
        var result = $("#loginResult");
        result.removeClass("success failure").text("");
        form.find("button[type='submit']").prop("disabled", true);

        $.ajax({
            url: "authenticate.php",
            type: "POST",
            data: { email: $("#email").val().trim(), password: $("#password").val() },
            success: function (response) {
                var parts = response.split("|");
                if (parts[0] === "success") {
                    window.location.href = "dashboard.php";
                } else {
                    result.addClass("failure").text(parts[1] || "Unable to log in.");
                }
            },
            error: function (xhr) {
                result.addClass("failure").text("AJAX error: " + xhr.status + ". Please try again.");
            },
            complete: function () {
                form.find("button[type='submit']").prop("disabled", false);
            }
        });
    });
});
