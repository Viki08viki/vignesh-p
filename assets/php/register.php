
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input (you should add more security measures)
    $username = htmlspecialchars($_POST["username"]);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // Connect to MySQL (replace with your actual MySQL credentials)
    $mysqli = new mysqli("your_mysql_host", "your_mysql_username", "your_mysql_password", "your_mysql_database");

    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Use prepared statement to insert user data into MySQL
    $stmt = $mysqli->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        echo "User registered successfully!";
    } else {
        echo "Error registering user: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
}
?>

