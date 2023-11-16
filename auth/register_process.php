<?php
include(__DIR__ . '/../config/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Prepare a SQL statement
    $stmt = $connection->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");

    // Bind parameters and execute the statement
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        // Registration successful, redirect to the login page
        header("Location: ../pages/login.php");
        exit(); // Ensure no more output is sent
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$connection->close();
