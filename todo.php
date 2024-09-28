<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TODO詳細</title>
</head>

<body>
    <?php require('dbconnect.php');
    $stmt = $db->prepare('select * from todo_lists where id=?');
    if (!$stmt) {
        die($db->error);
    }
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    if (!$id) {
        echo '表示するリストを指定してください';
        exit;
    }
    $stmt->bind_param('i', $id);
    $stmt->execute();

    $stmt->bind_result($id, $task, $todo, $status, $created);
    $result = $stmt->fetch();
    if (!$result) {
        echo '指定されたリストは見つかりませんでした';
        echo '<style>div{display:none;}</style>';
    }
    ?>

    <div>
        <dl>
            <dt>タスク名</dt>
            <dd><?php echo htmlspecialchars($task); ?></dd>
        </dl>
        <dl>
            <dt>詳細</dt>
            <dd><?php echo nl2br(htmlspecialchars($todo)); ?></dd>
        </dl>
        <dl>
            <dt>ステータス</dt>
            <dd><?php echo htmlspecialchars($status); ?></dd>
        </dl>
        <dl>
            <dt>登録日</dt>
            <dd><?php echo htmlspecialchars($created); ?></dd>
        </dl>
    </div>

    <a href="update.php?id=<?php echo $id; ?>">編集する</a>
    <a href="delete.php?id=<?php echo $id; ?>">削除する</a>
    <a href="/todo_lists">一覧へ</a>
</body>

</html>