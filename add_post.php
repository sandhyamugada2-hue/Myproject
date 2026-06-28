<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user']))
{
    header("Location: login.php");
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if(empty($title) || empty($content))
    {
        die("Title and Content are required");
    }

    $stmt = $conn->prepare(
        "INSERT INTO posts(title, content)
         VALUES (?, ?)"
    );

    $stmt->bind_param(
        "ss",
        $title,
        $content
    );

    if($stmt->execute())
    {
        header("Location: index.php");
        exit();
    }
    else
    {
        echo "Error adding post";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Post</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h2>Add New Post</h2>

    <form method="POST">

        <div class="mb-3">

            <label>Title</label>

            <input
                type="text"
                name="title"
                class="form-control"
                required
            >

        </div>

        <div class="mb-3">

            <label>Content</label>

            <textarea
                name="content"
                class="form-control"
                rows="5"
                required
            ></textarea>

        </div>

        <button
            type="submit"
            class="btn btn-success"
        >
            Add Post
        </button>

        <a
            href="index.php"
            class="btn btn-secondary"
        >
            Back
        </a>

    </form>

</div>

</body>
</html>