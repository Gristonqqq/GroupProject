<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sign_in'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "users_info";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }
    $stmt = $conn->prepare("SELECT password FROM registration WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $stored_hash = $row['password'];

        if (password_verify($pass, $stored_hash)) {
            echo 'Login successful';
        } else {
            echo 'Incorrect password';
        }
    } else {
        echo 'Email not registered';
    }
    $stmt->close();
    $conn->close();
}
?>
