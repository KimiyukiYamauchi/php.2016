<?php

require 'MDB2.php';	// PEARのMDB2モジュールをロード

// db_program://ユーザ名:パスワード@ドメイン名/データベース名
$db = MDB2::connect('mysqli://yamauchi:p@localhost/rensyu?charset=utf8');
if (MDB2::isError($db)) { die("Can't connect: " . $db->getMessage()); }

// この後のデータベースエラーに関してはメッセージを出力して抜け出す
$db->setErrorHandling(PEAR_ERROR_DIE);

$_POST['dish_search'] = 'そば%';

$sth = $db->prepare('SELECT dish_name, price FROM dishes'.
						' WHERE dish_name LIKE ?');
$result = $sth->execute(array($_POST['dish_search']));
$matches = $result->fetchAll();

var_dump($matches);