<?php
include 'db.php';

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST['title'];
    $content = $_POST['content'];

    $conn->query(
        "UPDATE posts
         SET title='$title',
             content='$content'
         WHERE id=$id"
    );

    header("Location: index.php");
    exit();
}

$result = $conn->query(
    "SELECT * FROM posts WHERE id=$id"
);

$row = $result->fetch_assoc();
?>

<h2>Edit Post</h2>

<form method="POST">

    Title:<br>
    <input type="text"
           name="title"
           value="<?php echo $row['title']; ?>">

    <br><br>

    Content:<br>

    <textarea name="content"
              rows="5"
              cols="40"><?php echo $row['content']; ?></textarea>

    <br><br>

    <button type="submit">
        Update Post
    </button>

</form>