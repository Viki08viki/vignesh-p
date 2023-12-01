// assets/js/login.js
function loginUser() {
    var username = $("#username").val();
    var password = $("#password").val();

    $.ajax({
        url: "login.php",
        type: "POST",
        data: {username: username, password: password},
        success: function(response) {
            // Handle the login response
            console.log(response);

            // Redirect to profile page if login is successful
            if (response === "Login successful") {
                window.location.href = "profile.html";
            }
        }
    });
}
