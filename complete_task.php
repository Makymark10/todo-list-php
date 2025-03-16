<?php
include "db.php"; 

if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['id'])) {
    $stmt = $conn->prepare("UPDATE tasks SET is_completed = 1 WHERE id=:id");
    $stmt->bindParam(":id", $_GET['id'], PDO::PARAM_INT);

    try {
        $stmt->execute();
        header("Location: index.php"); 
        exit();
    } catch (Exception $e) {
        echo "Something went wrong: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
