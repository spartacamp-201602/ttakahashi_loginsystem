<?php

session_start();

if (empty($_SESSION['id']))
{
    header('Location: login.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>会員限定画面</title>
</head>
<body>
    <h1>登録したユーザーのみ閲覧可能です！</h1>
</body>
</html>








