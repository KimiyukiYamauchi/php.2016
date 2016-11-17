<?php

require 'MDB2.php';	// PEARのMDB2モジュールをロード

// db_program://ユーザ名:パスワード@ドメイン名/データベース名
$db = MDB2::connect('mysqli://yamauchi:p@localhost/rensyu?charset=utf8');
if (MDB2::isError($db)) { die("Can't connect: " . $db->getMessage()); }

// この後のデータベースエラーに関してはメッセージを出力して抜け出す
$db->setErrorHandling(PEAR_ERROR_DIE);

$dish_id = $db->nextID('dishes2');

echo '$dish_id = ' . $dish_id . '<br>';

$db->query("INSERT INTO dishes2 (dish_id, dish_name, price, is_spicy)
    VALUES ($dish_id, 'Fried Bean Curd', 1.50, 0)");

echo 'OK!';