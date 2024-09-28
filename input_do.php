<?php
$task = filter_input(INPUT_POST, 'task', FILTER_SANITIZE_SPECIAL_CHARS);
$todo = filter_input(INPUT_POST, 'todo', FILTER_SANITIZE_SPECIAL_CHARS);
$status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_SPECIAL_CHARS);

if ($task === null || $todo === null || $status === null) {
    die('入力が正しくありません');
}

require('dbconnect.php');
$stmt = $db->prepare('INSERT INTO todo_lists (task, todo, status) VALUES (?, ?, ?)');

if (!$stmt) {
    die($db->error);
}

$stmt->bind_param('sss', $task, $todo, $status);
$success = $stmt->execute();

if (!$success) {
    die($stmt->error);
}

echo 'データが正常に保存されました';
echo '<br><a href="index.php">トップへ戻る</a>';
