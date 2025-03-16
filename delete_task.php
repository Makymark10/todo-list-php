

<?php
//this code will delete the task from the database
include "db.php"; 
if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['id'])) {
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id=:id");
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


<?php
//this will not totally delete the task from the database, it will only mark it as completed = 2(which is not 
// specify as complete but the data itself will remain in database) and not show it in the list of tasks

/*
include "db.php"; 

if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['id'])) {
    $stmt = $conn->prepare("UPDATE tasks SET is_completed = 2 WHERE id=:id");
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
*/
?>
