
<?php
session_start();

// Check if the user is logged in (you should add more security measures)
if (!isset($_SESSION["username"])) {
    echo "User not logged in";
    exit();
}

// Retrieve user information from MySQL (you need to set up a database)
$mysqli = new mysqli("your_mysql_host", "your_mysql_username", "your_mysql_password", "your_mysql_database");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$username = $_SESSION["username"];
$query = "SELECT * FROM users WHERE username = '$username'";
$result = $mysqli->query($query);

if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();

    // Now, you have $userData, which contains user information from MySQL

    // Connect to MongoDB (replace with your actual MongoDB credentials)
    $mongoClient = new MongoDB\Client("mongodb://your_mongo_host:27017");

    // Select the database and collection
    $db = $mongoClient->selectDatabase("your_mongo_database");
    $collection = $db->selectCollection("user_profiles");

    // Insert user profile data into MongoDB
    $profileData = [
        "username" => $userData["username"],
        "email" => $userData["email"],
        // Add other profile details as needed
    ];

    $collection->insertOne($profileData);

    echo json_encode($profileData);
} else {
    echo "User not found in MySQL database";
}

$mysqli->close();
?>
