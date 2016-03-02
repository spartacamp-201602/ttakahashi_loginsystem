<?php

session_start();


if(!empty($_SESSION['id']))
{
    unset($_SESSION['id']);
    header('Location: login.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン画面</title>
</head>
<body>
    <h1>ログイン画面です</h1>
    <form action="" method="post">
        ユーザネーム: <input type="text" name="name"><br>
        パスワード: <input type="text" name="password"><br>
        <input type="submit" value="ログイン">
    </form>
    <a href="signup.php">新規ユーザー登録はこちら</a>
</body>
</html>