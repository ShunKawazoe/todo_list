<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>todo入力</title>
</head>

<body>
    <form action="input_do.php" method="post">
        <input type="text" name="task" placeholder="することを入力してください">
        <textarea name="todo" cols="50" rows="5" placeholder="することの詳細を入力してください"></textarea>
        <select name="status">
            <?php
            require('dbconnect.php');

            function getEnumValues($db, $table, $column) {
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
                <option value="<?php echo $status; ?>"><?php echo $status; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">登録する</button>
    </form>
</body>

</html>
