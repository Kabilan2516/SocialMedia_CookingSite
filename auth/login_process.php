<?php

include(__DIR__ . '/../config/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user details from the database based on the provided username/email
    $query = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Password is correct, create a session and redirect to a dashboard or profile page
            $_SESSION['user_id'] = $user['user_id'];
            header("Location: ../pages/dashboard.php");
            exit();
        } else {
            echo "Incorrect password";
        }
    } else {
        echo "User not found";
    }
}

