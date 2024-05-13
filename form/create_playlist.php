<?php
$playlist_name = $_POST['playlist_name'];
$playlist_description = $_POST['playlist_description'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "playlists";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$playlist_name = $conn->real_escape_string($playlist_name);
$playlist_description = $conn->real_escape_string($playlist_description);

$stmt = $conn->prepare("INSERT INTO user_playlists(playlist_name, playlist_description) VALUES (?, ?)");
$stmt->bind_param("ss", $playlist_name, $playlist_description);

if ($stmt->execute()) {
    echo 'Playlist created successful';
} else {
    echo 'Error: ' . $conn->error;
}
$stmt->close();
$conn->close();
?>
