<?php
include 'db.php';

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if(empty($username) || empty($password))
    {
        die("All fields are required");
    }

    $check = $conn->prepare(
        "SELECT id FROM users WHERE username = ?"
    );

    $check->bind_param("s", $username);

    $check->execute();

    $result = $check->get_result();

    if($result->num_rows > 0)
    {
        echo "Username already exists";
    }
    else
    {
        $hashed_password = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $role = "editor";

        $stmt = $conn->prepare(
            "INSERT INTO users(username, password, role)
             VALUES (?, ?, ?)"
        );

        $stmt->bind_param(
            "sss",
            $username,
            $hashed_password,
            $role
        );

        if($stmt->execute())
        {
            echo "Registration Successful";
        }
        else
        {
            echo "Error";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h2>Register</h2>

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
            class="btn btn-success"
        >
            Register
        </button>

    </form>

</div>

</body>
</html>