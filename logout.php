<?php

session_start();

unset($_SESSION['id']);

session_destroy(); //$_SESSIONの中身が全て削除される

header('Location:login.php');
exit;


