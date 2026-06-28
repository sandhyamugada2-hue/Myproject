<?php
include 'db.php';

$limit = 3;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

$search = "";

if(isset($_GET['search']) && !empty($_GET['search']))
{
    $search = $_GET['search'];

    $sql = "SELECT * FROM posts
            WHERE title LIKE '%$search%'
            OR content LIKE '%$search%'
            LIMIT $start, $limit";

    $total_result = $conn->query(
        "SELECT COUNT(*) AS total
         FROM posts
         WHERE title LIKE '%$search%'
         OR content LIKE '%$search%'"
    );
}
else
{
    $sql = "SELECT * FROM posts
            LIMIT $start, $limit";

    $total_result = $conn->query(
        "SELECT COUNT(*) AS total
         FROM posts"
    );
}

$result = $conn->query($sql);

$total_rows = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $limit);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blog Application</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h1 class="text-center mb-4">
        Blog Management System
    </h1>

    <form method="GET" class="mb-4">

        <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Search posts..."
            value="<?php echo $search; ?>"
        >

        <button
            type="submit"
            class="btn btn-primary mt-2"
        >
            Search
        </button>

    </form>

    <a
        href="add_post.php"
        class="btn btn-success mb-4"
    >
        Add New Post
    </a>

    <?php
    while($row = $result->fetch_assoc())
    {
    ?>

        <div class="card mb-3">

            <div class="card-body">

                <h3 class="card-title">
                    <?php echo $row['title']; ?>
                </h3>

                <p class="card-text">
                    <?php echo $row['content']; ?>
                </p>

                <?php
                if(isset($row['created_at']))
                {
                    echo "<small class='text-muted'>Created: "
                         .$row['created_at']
                         ."</small><br><br>";
                }
                ?>

                <a
                    href="edit_post.php?id=<?php echo $row['id']; ?>"
                    class="btn btn-warning"
                >
                    Edit
                </a>

                <a
                    href="delete_post.php?id=<?php echo $row['id']; ?>"
                    class="btn btn-danger"
                    onclick="return confirm('Are you sure?')"
                >
                    Delete
                </a>

            </div>

        </div>

    <?php
    }
    ?>

    <div class="mt-4">

        <?php
        for($i = 1; $i <= $total_pages; $i++)
        {
            echo "<a class='btn btn-outline-primary me-1'
                     href='index.php?page=$i&search=$search'>
                     $i
                  </a>";
        }
        ?>

    </div>

</div>

</body>
</html>