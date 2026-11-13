// auth.js - sign up and log in with jQuery AJAX (Lab 8)
$(document).ready(function () {

    // Sign up: check the passwords, then send the form with AJAX
    $("#signupForm").submit(function (event) {
        event.preventDefault();
        var result = $("#signupMsg");
        var password = $("#password").val();
        var confirmPassword = $("#confirmPassword").val();
        result.removeClass("success failure");
        result.html("");

        if (password.length < 8) {
            result.addClass("failure");
            result.html("Password must be at least 8 characters.");
            return;
        }
        if (password !== confirmPassword) {
            result.addClass("failure");
            result.html("Passwords do not match.");
            return;
        }

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
                // PHP answers "success|message" or "error|message"
                var parts = response.split("|");
                if (parts[0] === "success") {
                    result.addClass("success");
                    result.html(parts[1]);
                    document.getElementById("signupForm").reset();
                } else {
                    result.addClass("failure");
                    result.html(parts[1]);
                }
            },
            error: function (xhr) {
                result.addClass("failure");
                result.html("AJAX error: " + xhr.status + ". Please try again.");
            }
        });
    });

    // Log in: send the form with AJAX and open the dashboard only after success
    $("#loginForm").submit(function (event) {
        event.preventDefault();

        $.ajax({
            url: "authenticate.php",
            type: "POST",
            data: { email: $("#email").val().trim(), password: $("#password").val() },
            success: function (response) {
                var parts = response.split("|");
                if (parts[0] === "success") {
                    window.location.href = "dashboard.php";
                } else {
                    // Wrong email or password: show a popup message
                    alert(parts[1]);
                }
            },
            error: function (xhr) {
                alert("AJAX error: " + xhr.status + ". Please try again.");
            }
        });
    });
});
