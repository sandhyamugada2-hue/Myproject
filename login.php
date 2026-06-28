
<?php
session_start();
include 'db.php';

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if(empty($username) || empty($password))
    {
        die("All fields are required");
    }

    $stmt = $conn->prepare(
        "SELECT * FROM users WHERE username = ?"
    );

    $stmt->bind_param("s", $username);

    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();

        if(password_verify($password, $row['password']))
        {
            $_SESSION['user'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            header("Location: index.php");
            exit();
        }
        else
        {
            echo "Invalid Password";
        }
    }
    else
    {
        echo "User not found";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h2>Login</h2>

    <form method="POST">

        <div class="mb-3">

            <label>Username</label>

            <input
                type="text"
                name="username"
                class="form-control"
                required
            >

        </div>

        <div class="mb-3">

            <label>Password</label>

            <input
                type="password"
                name="password"
                class="form-control"
                required
            >

        </div>

        <button
            type="submit"
            class="btn btn-primary"
        >
            Login
        </button>

    </form>

</div>

</body>
</html>