// assets/js/register.js
function registerUser() {
    var username = $("#username").val();
    var email = $("#email").val();
    var password = $("#password").val();

    $.ajax({
        url: "register.php",
        type: "POST",
        data: {username: username, email: email, password: password},
        success: function(response) {
            // Handle the registration response
            console.log(response);

            // Redirect to login page if registration is successful
            if (response === "User registered successfully!") {
                window.location.href = "login.html";
            }
        }
    });
}
