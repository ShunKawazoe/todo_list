<?php
require('dbconnect.php');

$stmt = $db->prepare('update todo_lists set task=?, todo=?, status=? where id=?');
if (!$stmt) {
    die($db->error);
}
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$task = filter_input(INPUT_POST, 'task', FILTER_SANITIZE_SPECIAL_CHARS);
$todo = $_POST['todo'];
$status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_SPECIAL_CHARS);

// htmlspecialchars でエスケープ
$todo = htmlspecialchars($todo, ENT_QUOTES, 'UTF-8');

$stmt->bind_param('sssi', $task, $todo, $status, $id);
$success = $stmt->execute();
if(!$success) {
    die($db->error);
}

header('Location: todo.php?id='. $id);
?>
