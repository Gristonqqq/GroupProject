<?php

// Підключення до Google Диску
require_once 'php_vendor/vendor/autoload.php'; // Підключення бібліотеки googleapis
$client = new Google_Client();
$client->setAuthConfig('../modules/musicsiteproject-a4a256ea7f3a.json');
$client->addScope(Google_Service_Drive::DRIVE);
$service = new Google_Service_Drive($client);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "music";

// Створення з'єднання
$conn = new mysqli($servername, $username, $password, $dbname);

// Перевірка з'єднання
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Отримання ID пісні з параметра запиту
$songId = $_GET['id'];

// SQL запит для отримання даних пісні з бази даних
$sql = "SELECT * FROM songs WHERE id = $songId";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Витягнення даних пісні з бази даних
    $row = $result->fetch_assoc();
    $title = $row['title'];
    $artist = $row['artist'];
    $genre = $row['genre'];

    // Отримання ідентифікатора файлу музики з Google Drive
    $musicFileId = $row['music_file_id'];

    // Отримання ідентифікатора файлу зображення з Google Drive
    $coverFileId = $row['cover_file_id'];

    // Відправлення даних у форматі JSON
    $response = array(
        'title' => $title,
        'artist' => $artist,
        'genre' => $genre,
        'musicFileId' => $musicFileId,
        'coverFileId' => $coverFileId
    );

    echo json_encode($response);
} else {
    // Якщо пісня з таким ID не знайдена
    echo "Song not found";
}

$conn->close();
?>
