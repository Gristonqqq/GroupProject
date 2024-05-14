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

// Отримання значень з форми та змінних, що містять ідентифікатори файлів
$title = $_POST['title'];
$artist = $_POST['artist'];
$genre = $_POST['genre'];

// SQL запит для вставки даних в таблицю
$sql = "INSERT INTO songs (title, artist, genre)
VALUES ('$title', '$artist', '$genre')";


// Виконання запиту до бази даних
if ($conn->query($sql) === TRUE) {
    $newRecordId = $conn->insert_id;

// Закриття з'єднання з базою даних

// Завантаження файлу музики
// Завантаження файлу музики
    $musicFilesFolderId = '1yQPjn6m9-QPTINUiWr8X9FfPwJK-d4rN';

// Завантаження файлу музики
    $musicFile = $_FILES['music'];
    $musicFileMetadata = new Google_Service_Drive_DriveFile(array(
        'name' => $newRecordId,
        'parents' => [$musicFilesFolderId] // Вказати ідентифікатор папки з музичними файлами
    ));
    $content = file_get_contents($musicFile['tmp_name']);
    $musicFile = $service->files->create($musicFileMetadata, array(
        'data' => $content,
        'mimeType' => 'audio/*',
        'uploadType' => 'multipart',
        'fields' => 'id'
    ));

// Отримання ідентифікатора папки для зображень музики
// Отримання ідентифікатора папки для зображень музики
    $musicCoversFolderId = '1p6H5uhZTBmsswv5Ahpz_2-OlR8tDIi-G';

// Завантаження файлу зображення
    $coverFile = $_FILES['cover'];
    $coverFileMetadata = new Google_Service_Drive_DriveFile(array(
        'name' => $newRecordId, // Змінюємо ім'я папки на ім'я треку з додаванням суфіксу "_cover"
        'parents' => [$musicCoversFolderId] // Вказати ідентифікатор папки з зображеннями музики
    ));
    $content = file_get_contents($coverFile['tmp_name']);
    $coverFile = $service->files->create($coverFileMetadata, array(
        'data' => $content,
        'mimeType' => 'image/*',
        'uploadType' => 'multipart',
        'fields' => 'id'
    ));
    header("Location: http://localhost:63342/GroupProject/index.html");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Отримання ID завантажених файлів
$musicFileId = $musicFile->id;
$coverFileId = $coverFile->id;
$conn->close();

?>
