function validateForm() {
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirm_password").value;

    if (!/^[a-zA-Z0-9]+$/.test(username) || username.length < 5) {
        alert("Username must be alphanumeric and have at least 5 characters.");
        return false;
    }

    if (password !== confirmPassword) {
        alert("Passwords do not match.");
        return false;
    }

    return true;
}
    function submitForm() {
        // Assuming your form has an id "profileForm"
        var form = document.getElementById('profileForm');
        form.submit();
    }