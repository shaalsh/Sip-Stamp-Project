
// Check the sign up form before submitting
const signupForm = document.getElementById("signupForm");

if (signupForm) {

    signupForm.addEventListener("submit", function(event) {

        // Get the password values
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirmPassword").value;
        const signupMsg = document.getElementById("signupMsg");

        signupMsg.textContent = "";

        // Check the password length
        if (password.length < 8) {
            event.preventDefault();
            signupMsg.textContent = "Password must be at least 8 characters.";
            return;
        }

        // Check if the passwords match
        if (password !== confirmPassword) {
            event.preventDefault();
            signupMsg.textContent = "Passwords do not match.";
            return;
        }

    });
}
