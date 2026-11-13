
// Check the sign up form before submitting
var signupForm = document.getElementById("signupForm");

if (signupForm) {

    signupForm.addEventListener("submit", function(event) {

        // Get the password values
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirmPassword").value;
        var signupMsg = document.getElementById("signupMsg");

        signupMsg.innerHTML = "";

        // Check the password length
        if (password.length < 8) {
            event.preventDefault();
            signupMsg.innerHTML = "Password must be at least 8 characters.";
            return;
        }

        // Check if the passwords match
        if (password !== confirmPassword) {
            event.preventDefault();
            signupMsg.innerHTML = "Passwords do not match.";
            return;
        }

    });
}
