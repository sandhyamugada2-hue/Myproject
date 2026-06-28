<?php
<<<<<<< HEAD
include 'db.php';

$result = $conn->query("SELECT * FROM posts");
?>

<h2>All Blog Posts</h2>

<a href="add_post.php">Add New Post</a>
<br><br>

<?php
while($row = $result->fetch_assoc()) {
?>
    <h3><?php echo $row['title']; ?></h3>

    <p><?php echo $row['content']; ?></p>

    <a href="edit_post.php?id=<?php echo $row['id']; ?>">
        Edit
    </a>

    |

    <a href="delete_post.php?id=<?php echo $row['id']; ?>">
        Delete
    </a>

    <hr>

<?php
}
=======
echo "Hello ApexPlanet!";
>>>>>>> 6ccf50e77b2d102e7467926e46aabeea5f5011b6
?>