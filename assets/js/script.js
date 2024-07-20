$(document).ready(function() {
    $('#loginForm').submit(function(event) {
        // Reset any previous error messages
        $('.error-message').text('');

        var username = $('#username').val().trim();
        var password = $('#password').val().trim();
        var valid = true;

        // Validate username
        if (username === '') {
            $('#username-error').text('Username is required');
            valid = false;
        }

        // Validate password
        if (password === '') {
            $('#password-error').text('Password is required');
            valid = false;
        }

        // Prevent form submission if validation fails
        if (!valid) {
            event.preventDefault();
        }
    });
});
