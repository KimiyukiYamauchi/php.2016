<?php

require 'MDB2.php';	// PEARのMDB2モジュールをロード

// db_program://ユーザ名:パスワード@ドメイン名/データベース名
$db = MDB2::connect('mysqli://yamauchi:p@localhost/rensyu?charset=utf8');
if (MDB2::isError($db)) { die("Can't connect: " . $db->getMessage()); }

// この後のデータベースエラーに関してはメッセージを出力して抜け出す
$db->setErrorHandling(PEAR_ERROR_DIE);

$_POST['new_dish_name'] = 'カツカレー';
$_POST['new_price'] = 7;
$_POST['is_spicy'] = 1;

$sth = $db->prepare('INSERT INTO dishes (dish_name,price,is_spicy) VALUES (?,?,?)');
$sth->execute(array($_POST['new_dish_name'], $_POST['new_price'], $_POST['is_spicy']));

echo 'OK!!!';