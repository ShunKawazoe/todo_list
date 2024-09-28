<?php
require('dbconnect.php');
$stmt = $db->prepare('SELECT * FROM todo_lists WHERE id = ?');
if(!$stmt) {
    die($db->error);
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$stmt->bind_param('i', $id);
$stmt->execute();

$stmt->bind_result($id, $task, $todo, $status, $created);
$result=$stmt->fetch();
if(!$result) {
    die('TODOの指定がありません');
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>todoの編集</title>
</head>

<body>
    <form action="update_do.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="text" name="task" value="<?php echo htmlspecialchars($task); ?>">
        <textarea name="todo" cols="50" rows="10" placeholder=""><?php echo htmlspecialchars($todo); ?></textarea>
        <select name="status">
            <?php
            require('dbconnect.php');

            function getEnumValues($db, $table, $column)
            {
                $sql = "SHOW COLUMNS FROM $table LIKE '$column'";
                $stmt = $db->query($sql);
                $row = $stmt->fetch_assoc();
                preg_match("/^enum\(\'(.*)\'\)$/", $row['Type'], $matches);
                $enum = explode("','", $matches[1]);
                return $enum;
            }
            $statuses = getEnumValues($db, 'todo_lists', 'status');
            foreach ($statuses as $status) :
            ?>
                <option name="status" value="<?php echo $status; ?>"><?php echo $status; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">編集する</button>
    </form>
</body>

</html>