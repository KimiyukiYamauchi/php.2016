<?php

require 'MDB2.php';	// PEARのMDB2モジュールをロード

// db_program://ユーザ名:パスワード@ドメイン名/データベース名
$db = MDB2::connect('mysqli://yamauchi:p@localhost/rensyu');
if (MDB2::isError($db)) { die("Can't connect: " . $db->getMessage()); }

// この後のデータベースエラーに関してはメッセージを出力して抜け出す
$db->setErrorHandling(PEAR_ERROR_DIE);

$q = $db->query("INSERT INTO dishes (dish_size, dish_name, price, is_spicy)
    VALUES ('large', 'Sesame Seed Puff', 2.50, 0)");
//if (MDB2::isError($q)) { die("query error: " . $q->getMessage()); }

print "Query Succeeded!";