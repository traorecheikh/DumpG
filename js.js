function validateForm() {
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirm_password").value;

    if (!/^[a-zA-Z0-9]+$/.test(username) || username.length < 5) {
        alert("le nom d'utilisateur doit etre alphanumerique et avoir minimum 5 caractere.");
        return false;
    }

    if (password !== confirmPassword) {
        alert("Passwords do not match.");
        return false;
    }

    return true;
}
    function submitForm() {
        var form = document.getElementById('profileForm');
        form.submit();
    }