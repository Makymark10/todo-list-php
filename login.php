<?php
session_start();
include "db.php";

$error = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = $conn->prepare("SELECT * FROM userAccount WHERE username= :username");
    $query->bindParam(":username", $username);
    $query->execute();

    $user = $query->fetch();
    if ($user) {
        if (password_verify($password, $user['userpass'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['idUser'] = $user['idUser'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Incorrect username or password.";
        }
    } else {
        $error = "Incorrect username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ToDoList</title>
    <link rel="stylesheet" href="/style/login.css">
</head>
<body>
    <form action="" class="container" method="POST">
        <div class="loginform">
            <h1 class="login">Login</h1>
            <div class="line"></div>

            <h1 class="username">Username</h1>
            <input type="text" name="username" id="username" placeholder="Username" required>
            <h1 class="userpass">Password</h1>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <?php if (!empty($error)) {
                        echo "<p class='error'>$error</p>";
                    }
            ?>
            <button class="loginbtn">Login</button>

            <p class="signup">
                Don't have an Account?
                <a href="/signup.php">Signup</a>
            </p>
        </div>
    </form>
</body>
</html>
