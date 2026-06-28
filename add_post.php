<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "INSERT INTO posts(title, content)
            VALUES('$title', '$content')";

    if ($conn->query($sql)) {
        echo "Post added successfully!";
    }
}
?>

<h2>Add Blog Post</h2>

<form method="POST">
    Title:<br>
    <input type="text" name="title" required><br><br>

    Content:<br>
    <textarea name="content" rows="5" cols="40" required></textarea><br><br>

    <button type="submit">Add Post</button>
</form>

<br>
<a href="index.php">View Posts</a>