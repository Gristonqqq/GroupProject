<?php
$email = $_POST['email'];
$name = $_POST['name'];
$pass = $_POST['pass'];

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users_info";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$email = $conn->real_escape_string($email);
$name = $conn->real_escape_string($name);
$pass = password_hash($pass, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO registration (email, name, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $email, $name, $pass);

if ($stmt->execute()) {
    echo 'Registration successful';
} else {
    echo 'Error: ' . $conn->error;
}
$stmt->close();
$conn->close();
?>
