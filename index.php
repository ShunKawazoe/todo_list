<?php
require('dbconnect.php');

$counts = $db->query('select count(*) as cnt from todo_lists');
$count = $counts->fetch_assoc();
$max_page = floor(($count['cnt'] + 1) / 5);

$stmt = $db->prepare('select * from todo_lists order by id asc limit ?, 5');
if (!$stmt) {
    die($db->error);
}
$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);
$page = ($page ?: 1);
$start = ($page - 1) * 5;
$stmt->bind_param('i', $start);
$result = $stmt->execute(); 
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TODOリスト</title>
</head>

<body>
    <h1>TODOリスト.</h1>
    <a href="input.php">することを登録する</a>
    <dl>
        <dt>タスク名</dt>
        <dd>詳細</dd>
        <dd>対応状況</dd>
        <dd>登録日</dd>
    </dl>
    <?php if (!$result) : ?>
        <p>表示するtodoはありません</p>
    <?php endif; ?>
    <?php $stmt->bind_result($id, $task, $todo, $status, $created); ?>
    <?php while ($stmt->fetch()) : ?>
        <dl>
            <dt>
                <a href="todo.php?id=<?php echo $id; ?>"><?php echo htmlspecialchars($task); ?></a>
            </dt>
            <dd>
                <?php echo htmlspecialchars(mb_substr($todo, 0, 50)); ?>
            </dd>
            <dd>
                <?php echo htmlspecialchars($status); ?>
            </dd>
            <dd>
                <?php echo htmlspecialchars($created); ?>
            </dd>
        </dl>
    <?php endwhile; ?>
    <?php if ($page > 1) : ?>
        <p><a href="?page=<?php echo $page - 1; ?>"><?php echo $page - 1; ?>ページ目へ</a></p>
    <?php endif; ?>
    <?php if ($page < $max_page) : ?>
        <p><a href="?page=<?php echo $page + 1; ?>"><?php echo $page + 1; ?>ページ目へ</a></p>
    <?php endif; ?>
</body>

</html>