
<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input (you should add more security measures)
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);

    // Connect to MySQL (replace with your actual MySQL credentials)
    $mysqli = new mysqli("your_mysql_host", "your_mysql_username", "your_mysql_password", "your_mysql_database");

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Use prepared statement to check user credentials
    $stmt = $mysqli->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $userData["password"])) {
            // Set session for logged-in user
            $_SESSION["username"] = $username;

            // Connect to MongoDB (replace with your actual MongoDB credentials)
            $mongoClient = new MongoDB\Client("mongodb://your_mongo_host:27017");

            // Select the database and collection
            $db = $mongoClient->selectDatabase("your_mongo_database");
            $collection = $db->selectCollection("user_profiles");

            // Retrieve additional profile data from MongoDB
            $profileData = $collection->findOne(["username" => $username]);

            echo json_encode(["login_status" => "success", "profile_data" => $profileData]);
        } else {
            echo json_encode(["login_status" => "fail", "message" => "Invalid username or password"]);
        }
    } else {
        echo json_encode(["login_status" => "fail", "message" => "User not found"]);
    }

    $stmt->close();
    $mysqli->close();
} else {
    // Redirect to index.html if accessed directly
    header("Location: index.html");
    exit();
}
?>
