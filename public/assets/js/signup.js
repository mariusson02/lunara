document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector(".signup-box-form");
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirm_password");

    form.addEventListener("submit", (event) => {
        if (password.value !== confirmPassword.value) {
            event.preventDefault();
            displayAlert(false, 'Passwords do not match.');
            confirmPassword.focus();
        }
    });
});
