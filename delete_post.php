<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user']))
{
    header("Location: login.php");
    exit();
}

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin')
{
    die("Access Denied. Only admins can delete posts.");
}

if(isset($_GET['id']))
{
    $id = (int)$_GET['id'];

    $stmt = $conn->prepare(
        "DELETE FROM posts WHERE id = ?"
    );

    $stmt->bind_param("i", $id);

    if($stmt->execute())
    {
        header("Location: index.php");
        exit();
    }
    else
    {
        echo "Error deleting post";
    }
}
else
{
    echo "Invalid request";
}
?>