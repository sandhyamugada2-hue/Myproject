<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user']))
{
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

$stmt = $conn->prepare(
    "SELECT * FROM posts WHERE id = ?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if(empty($title) || empty($content))
    {
        die("Title and Content are required");
    }

    $update = $conn->prepare(
        "UPDATE posts
         SET title = ?, content = ?
         WHERE id = ?"
    );

    $update->bind_param(
        "ssi",
        $title,
        $content,
        $id
    );

    if($update->execute())
    {
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h2>Edit Post</h2>

    <form method="POST">

        <div class="mb-3">

            <label>Title</label>

            <input
                type="text"
                name="title"
                class="form-control"
                value="<?php echo htmlspecialchars($row['title']); ?>"
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
            ><?php echo htmlspecialchars($row['content']); ?></textarea>

        </div>

        <button
            type="submit"
            class="btn btn-warning"
        >
            Update Post
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