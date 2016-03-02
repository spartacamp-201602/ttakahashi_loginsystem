<?php
require_once('config.php');
require_once('functions.php');

session_start();

if(empty($_SESSION['id']))
{
    header('Location: login.php');
}

//フォーム内にあらかじめ表示させる値を取得
$dbh = connectDatabase();

$sql ='select * from users where id = :id';

$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id',$_SESSION['id']);

$stmt->execute();

$edit_user = $stmt->fetch(PDO::FETCH_ASSOC);



if($_SERVER['REQUEST_METHOD']==='POST')
{
    $errors =array();

    $name = $_POST['name'];
    $password =$_POST['password'];

//バリデーション
    if(empty($name))
    {
        $errors[]='ユーザーネームが未入力です';
    }

    if(empty($password))
    {
        $errors[]='パスワードが未入力です';
    }


// 名前が重複するときエラー文を表示
    $sql ='select * from users';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // var_dump($users);

    foreach ($users as $user)
    {
        if($name === $edit_user['name'])
        {
            break; //元の名前と同じときは編集できる
        }

        if($name === $user['name'])
        {
            $errors[] ='すでにこのユーザネームは使われています';
            break;//すでに登録されてる名前には編集できない
        }
    }



//バリデーション突破
    if(empty($errors))
    {

        $sql ='update users set name = :name,';
        $sql.='password = :password where id = :id';

        $stmt = $dbh->prepare($sql);

        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':password',$password);
        $stmt->bindParam(':id',$_SESSION['id']);
        $stmt->execute();

        header('Location: index.php');
        exit;
    }

}



?>



<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>ユーザ情報編集</title>
</head>
<style>
.error{
    color:red;
    list-style: none;
}
</style>



<body>

<h1>ユーザ情報編集</h1>

<?php if(isset($errors)) : ?>
        <div class = "error">
            <?php foreach($errors as $error) : ?>
                <li><?php echo $error; ?></li>
            <?php endforeach ; ?>
        </div>
<?php endif ; ?>

<form acition="", method="post">
    <p>ユーザネーム：<input type="text" name="name" value="<?= $edit_user['name'];?>"></p>

    <p>パスワード：<input type="text" name="password" value="<?= $edit_user['password'];?>"></p>

    <p><input type = "submit" value ="編集する" ></p>

    <p><a href = "index.php">戻る</a> </p>
</form>

</body>


</html>

