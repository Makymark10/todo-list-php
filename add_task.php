<?php
session_start();
include "db.php"; 

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['addtask'])) {
    $addtask = trim($_POST['addtask']); 
    $iduserLogin = $_SESSION['idUser'];
    if (!empty($addtask)) {
        $query = $conn->prepare("INSERT INTO tasks (task_name, idUser) VALUES (:adtask, :idUser)");
        $query->bindParam(":idUser", $iduserLogin, PDO::PARAM_INT);
        $query->bindParam(":adtask", $addtask, PDO::PARAM_STR);
        try {
            $query->execute();
            header("Location: index.php"); 
            exit();
        } catch (Exception $e) {
            echo "Something went wrong: " . $e->getMessage();
        }
    } else {
        echo "Task name cannot be empty.";
    }
} else {
    echo "Invalid request.";
}
?>
