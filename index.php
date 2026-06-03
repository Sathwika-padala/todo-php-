<?php
// Task storage using PHP session
session_start();

// Initialize tasks array if not set
if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

// Handle Add Task
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_task'])) {
    $task = trim($_POST['task'] ?? '');
    if ($task !== '') {
        $_SESSION['tasks'][] = [
            'id'   => uniqid(),
            'text' => htmlspecialchars($task, ENT_QUOTES, 'UTF-8'),
            'done' => false,
        ];
    }
    header('Location: index.php');
    exit;
}

// Handle Delete Task
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_task'])) {
    $id = $_POST['task_id'] ?? '';
    $_SESSION['tasks'] = array_values(
        array_filter($_SESSION['tasks'], fn($t) => $t['id'] !== $id)
    );
    header('Location: index.php');
    exit;
}

// Handle Toggle Done
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_task'])) {
    $id = $_POST['task_id'] ?? '';
    foreach ($_SESSION['tasks'] as &$t) {
        if ($t['id'] === $id) {
            $t['done'] = !$t['done'];
            break;
        }
    }
    unset($t);
    header('Location: index.php');
    exit;
}

$tasks      = $_SESSION['tasks'];
$totalTasks = count($tasks);
$doneTasks  = count(array_filter($tasks, fn($t) => $t['done']));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Taskly — To-Do List</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
</head>
<body>

    <div class="app-wrapper">

        <!-- Header -->
        <header class="app-header">
            <div class="logo-mark">✦</div>
            <h1 class="app-title">Taskly</h1>
            <p class="app-subtitle">Stay focused. Get things done.</p>

            <?php if ($totalTasks > 0): ?>
            <div class="progress-bar-wrap">
                <div class="progress-bar-track">
                    <div class="progress-bar-fill" style="width: <?= $totalTasks ? round(($doneTasks / $totalTasks) * 100) : 0 ?>%"></div>
                </div>
                <span class="progress-label"><?= $doneTasks ?> / <?= $totalTasks ?> complete</span>
            </div>
            <?php endif; ?>
        </header>

        <!-- Add Task Form -->
        <div class="card add-card">
            <form method="POST" action="index.php" class="add-form">
                <div class="input-group">
                    <input
                        type="text"
                        name="task"
                        class="task-input"
                        placeholder="What needs to be done?"
                        maxlength="200"
                        autocomplete="off"
                        required
                    />
                    <button type="submit" name="add_task" class="btn btn-add">
                        <span class="btn-icon">+</span>
                        <span>Add Task</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Task List -->
        <div class="card tasks-card">
            <?php if (empty($tasks)): ?>
                <div class="empty-state">
                    <div class="empty-icon">◎</div>
                    <p class="empty-title">All clear!</p>
                    <p class="empty-sub">Add a task above to get started.</p>
                </div>
            <?php else: ?>
                <ul class="task-list">
                    <?php foreach ($tasks as $task): ?>
                    <li class="task-item <?= $task['done'] ? 'task-done' : '' ?>">

                        <!-- Toggle Done -->
                        <form method="POST" action="index.php" class="toggle-form">
                            <input type="hidden" name="task_id" value="<?= $task['id'] ?>" />
                            <button type="submit" name="toggle_task" class="check-btn" title="Mark complete">
                                <?php if ($task['done']): ?>
                                    <span class="check-icon check-filled">✓</span>
                                <?php else: ?>
                                    <span class="check-icon check-empty"></span>
                                <?php endif; ?>
                            </button>
                        </form>

                        <!-- Task Text -->
                        <span class="task-text"><?= $task['text'] ?></span>

                        <!-- Delete -->
                        <form method="POST" action="index.php" class="delete-form">
                            <input type="hidden" name="task_id" value="<?= $task['id'] ?>" />
                            <button type="submit" name="delete_task" class="btn btn-delete" title="Delete task">
                                ✕
                            </button>
                        </form>

                    </li>
                    <?php endforeach; ?>
                </ul>

                <?php if ($doneTasks > 0): ?>
                <div class="clear-done-wrap">
                    <form method="POST" action="clear_done.php">
                        <!-- Handled inline below via a hidden trick — just show text -->
                    </form>
                    <p class="done-hint"><?= $doneTasks ?> task<?= $doneTasks > 1 ? 's' : '' ?> marked complete ✦</p>
                </div>
                <?php endif; ?>

            <?php endif; ?>
        </div>

        <footer class="app-footer">
            <p>Built with PHP &amp; CSS · No database required</p>
        </footer>

    </div>

</body>
</html>
