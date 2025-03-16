<?php
session_start();
include "db.php"; 

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $taskName = ($_POST['task_name']); 
    $taskId = ($_POST['task_id']);
    $iduserLogin = $_SESSION['idUser'];

    if (!empty($taskName)) {
        $query = $conn->prepare("UPDATE tasks SET task_name = :taskName WHERE id = :taskId AND idUser = :idUser");
        $query->bindParam(":taskName", $taskName, PDO::PARAM_STR);
        $query->bindParam(":taskId", $taskId, PDO::PARAM_INT);
        $query->bindParam(":idUser", $iduserLogin, PDO::PARAM_INT);
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