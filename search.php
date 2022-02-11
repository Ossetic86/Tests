<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta charset="utf-8">
    <title>Поиск</title>
</head>
<body>
<form action="search.php" method="post">
    <p>Введите текст поиска</p>
    <input type="text" size="50" minlength="3" name="swrd">
    <input type="submit" value="Отправить">
</form>

<?php
if (isset($_POST['swrd'])) {
    $db_connect= new mysqli('127.0.0.1', 'usr2022','1');
    $db_connect-> query('USE InLineTest');
    $result = $db_connect->query("select posts.title, comments.body from posts JOIN comments ON posts.id=comments.postId WHERE comments.body LIKE'%".trim($_POST['swrd'])."%'");
    echo "<br><table border='1'><tr><td>№</td><td>Тема сообщения</td><td>Комментарий</td></tr>";
    $i = 1;
    while ($res = $result->fetch_row()) {
        echo "<tr><td>$i</td><td>$res[0]</td><td>$res[1]</td></tr>";
        $i++;
    }
    echo "</<table>";
}
?>

</body>
</html>
