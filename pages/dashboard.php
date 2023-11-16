<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DesiDishes</title>
    <link rel="stylesheet" href="../css/index.css">
    <!-- font awsam -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <!-- Card -->
    <div class="card-body">

    </div>

    <form id="postForm" enctype="multipart/form-data">
        <div>
            <label for="postTitle">Post Title:</label>
            <input type="text" id="postTitle" name="postTitle" required>
        </div>
        <div>
            <label for="postImage">Upload Image:</label>
            <input type="file" id="postImage" name="postImage" accept="image/*" required>
        </div>
        <div>
            <label for="siteURL">Site URL:</label>
            <input type="url" id="siteURL" name="siteURL" required>
        </div>
        <button type="submit" id="submitForm">Submit</button>
    </form>


    <a href="../pages/login.php">Logout</a>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../js/index.js"></script>
</body>

</html>