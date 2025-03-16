<?php
    session_start();
    if (!isset($_SESSION['idUser'])) {
        header('Location: /login.php');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<?php
    include 'db.php'; 
    $query = $conn->prepare("SELECT * FROM tasks WHERE is_completed = 0 AND idUser = :idUser");
    $query->bindParam(":idUser", $_SESSION['idUser']);
    $query->execute();
    $tasks = $query->fetchAll();

    $query = $conn->prepare("SELECT * FROM tasks WHERE is_completed = 1 AND idUser = :idUser");
    $query->bindParam(":idUser", $_SESSION['idUser']);
    $query->execute();
    $completedTasks = $query->fetchAll();
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sticky Wall Todo List</title>
    <link rel="stylesheet" href="/style/style.css">
</head>
<body>
    <main class="containerlist">
        <?php 
            echo "<h3 class='nameUser'> Welcome, {$_SESSION['username']}</h3>";
        ?>
        <div class="header">
            <h2>Sticky Wall Todo List</h2>
            <a href="logout.php" class="logout">Logout</a>
        </div>
        <form action="add_task.php" method="POST" class="task-form">
            <input type="text" name="addtask" placeholder="Enter a new task" required>
            <button type="submit">Add</button>
        </form>
        <?php
            function randomLightColor() {
                $r = rand(200, 255); 
                $g = rand(200, 255); 
                $b = rand(200, 255); 
                return "rgba($r, $g, $b, 0.8)"; 
            }
        ?>

        <h3>Pending Tasks</h3>
        <div class="task-grid">
            <?php
                if (!empty($tasks)) {
                    foreach ($tasks as $task) {
                        $randomColor = randomLightColor(); 
                        $modalId = "editModal" . $task['id'];
                        echo "<div class='task-card' style='background-color: {$randomColor};'>
                                <span>{$task['task_name']}</span>
                                <span class='created'>Created At: {$task['created_at']}</span>
                                <div class='task-actions'>
                                    <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#{$modalId}'>
                                        edit
                                    </button>
                                    <a href='complete_task.php?id={$task['id']}' class='complete'>✔</a>
                                    <a onclick='confirm1({$task['id']})' class='delete'>✖</a>
                                </div>
                            </div>";
                        
                        echo "
                        <div class='modal fade p-1' id='{$modalId}' tabindex='-1' aria-labelledby='{$modalId}Label' aria-hidden='true'>
                            <div class='modal-dialog modal-dialog-centered'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='{$modalId}Label'>Edit Task: {$task['task_name']}</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                    </div>
                                    <div class='modal-body'>
                                        <form action='update_task.php' method='POST'>
                                            <input type='hidden' name='task_id' value='{$task['id']}'>
                                            <div class='mb-3'>
                                                <label for='taskName{$task['id']}' class='form-label'>Task Name</label>
                                                <input type='text' class='form-control' id='taskName{$task['id']}' name='task_name' value='{$task['task_name']}'>
                                            </div>
                                            <!--<div class='mb-3'>
                                                <label for='createdAt{$task['id']}' class='form-label'>Created At</label>
                                                <input type='text' class='form-control' id='createdAt{$task['id']}' name='created_at' value='{$task['created_at']}' readonly>
                                            </div>-->
                                            <div class='modal-footer'>
                                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                                <button type='submit' class='btn btn-primary'>Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>";
                    }
                } else {
                    echo "<p class='no-tasks'>No pending tasks.</p>";
                }
            ?>
        </div>

        <h3>Completed Tasks</h3>
        <div class="task-grid">
            <?php
                if (!empty($completedTasks)) {
                    foreach ($completedTasks as $task) {
                        echo "<div class='task-card completed-task'>
                                <s>{$task['task_name']}</s>
                                <span class='created'>Created At: {$task['created_at']}</span>
                                <div class='task-actions'><a onclick='confirm1(" . $task['id'] . ")' class='delete'>✖</a></div>
                            </div>";

                    }
                } else {
                    echo "<p class='no-tasks'>No completed tasks yet.</p>";
                }
            ?>
        </div>
    </main>

    <script>
        function confirm1(id) {
            const c = confirm("Are you sure?");
            if (c) {
                window.location = "delete_task.php?id=" + id;
            }
        }
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
