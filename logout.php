<?php
session_start();
session_destroy();

header("Location: login.php");
exit();
?>
<a href="logout.php" class="btn btn-danger">
    Logout
</a>