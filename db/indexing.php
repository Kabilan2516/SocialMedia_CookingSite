<?php

function getData()
{
    include(__DIR__ . '/../config/db.php');
    $sql = "SELECT image_data, post_title, media_url, post_id, user_id FROM posts";

    $result = $connection->query($sql);

    // check if theere are posts
    if ($result->num_rows >  0) {
        $posts = [];

        while ($row = $result->fetch_assoc()) {
            $row['image_data'] = base64_encode($row['image_data']);
            $posts[] = $row;
        }

        // Output posts as JSON
        header('Content-Type: application/json');
        echo json_encode($posts);
    } else {
        echo json_encode([]);
    }

    $connection->close();
}

function incressCount()
{
    include(__DIR__ . '/../config/db.php');

    $action = $_POST['action'];
    $postId = $_POST['post_id'];
    $userId = $_POST['user_id'];

    // update the count in the database based on the action
    switch ($action) {
        case 'like':

            $sql = "UPDATE posts SET like_count = like_count + 1 WHERE post_id = $postId";
            break;
        case 'comment':
            $sql = "UPDATE posts SET comment_count = comment_count + 1 WHERE post_id = $postId";
            break;
        case 'link':
            $sql = "UPDATE posts SET share_count = share_count + 1 WHERE post_id = $postId";
            break;

        default:
            # code...
            break;
    }

    if ($connection->query($sql) === TRUE) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $connection->error]);
    }
    $connection->close();
}

function uplodPostData()
{
    include(__DIR__ . '/../config/db.php');
    $postTitle = $_POST['postTitle'];
    $siteURL = $_POST['siteURL'];
    $postImage = file_get_contents($_FILES['postImage']['tmp_name']); // Get image content as binary

    // Check if the file is an actual image
    $check = getimagesize($_FILES['postImage']['tmp_name']);
    if ($check !== false) {
        // Insert data into the database
        $sql = "INSERT INTO posts (post_title, media_url, image_data) VALUES (?, ?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("sss", $postTitle, $siteURL, $postImage);
        if ($stmt->execute()) {
            echo "Post inserted successfully";
        } else {
            echo "Error inserting post: " . $connection->error;
        }
        $stmt->close();
    } else {
        echo "File is not an image";
    }
}



// check if a function parameter is provided

if ($_SERVER['REQUEST_METHOD'] === 'GET' || $_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestedFunction = null;

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['function'])) {
        $requestedFunction = $_GET['function'];
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['function'])) {
        $requestedFunction = $_POST['function'];
    }

    if ($requestedFunction !== null) {
        if (function_exists($requestedFunction)) {
            call_user_func($requestedFunction);
        } else {
            echo json_encode(['error' => 'Function not found']);
        }
    } else {
        echo json_encode(['error' => 'No function specified']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
