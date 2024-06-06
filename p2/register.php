<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "olearn";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $c_pass = $_POST['c_pass'];
    $role = $_POST['role'];

    // Check if passwords match
    if ($pass != $c_pass) {
        echo "Passwords do not match.";
        exit();
    }

    // Hash the password
    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

    // Insert data into users table
    $sql = "INSERT INTO users (username, email, password, role) VALUES ('$name', '$email', '$hashed_pass', '$role')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to home page after successful registration
        header("Location: home.html");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
