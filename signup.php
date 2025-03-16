<?php
session_start();
include "db.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashpass = password_hash($password, PASSWORD_DEFAULT);

    $query = $conn->prepare("INSERT INTO useraccount (username, userpass) VALUES (:fname, :pw)");
    $query->bindParam(":fname", $username);
    // $query->bindParam(":pw", $password);
    $query->bindParam(":pw", $hashpass);

    try {
        $query->execute();
        header("Location: login.php");
    } catch (\Throwable $th) {
        echo "Something went wrong. Please try again.!!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - ToDoList</title>
    <link rel="stylesheet" href="/style/login.css">
</head>
<body>
    <form action="" class="container"  method="POST">
    <div class="loginform">
                <h1 class="login">Signup</h1>
                <div class="line"></div>
                <h1 class="username">Username</h1>
                <input type="text" name="username" id="username" placeholder="Username" required>
                <h1 class="userpass">Password</h1>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <button class="loginbtn">Signup</button>
                <p class="signup">
                    Already have an Account?
                    <a href="/login.php">Login</a>
                </p>
            </div>
    </form>
</body>
</html>
