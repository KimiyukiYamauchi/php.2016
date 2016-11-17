<?php

require 'MDB2.php';	// PEARのMDB2モジュールをロード

// db_program://ユーザ名:パスワード@ドメイン名/データベース名
$db = MDB2::connect('mysqli://yamauchi:p@localhost/rensyu');
if (MDB2::isError($db)) { die("Can't connect: " . $db->getMessage()); }

// この後のデータベースエラーに関してはメッセージを出力して抜け出す
$db->setErrorHandling(PEAR_ERROR_DIE);

// Decrease the price some some dishes
$count = $db->exec("UPDATE dishes SET price=price - 1 WHERE price > 5");
print 'Changed the price of ' . $count . 'rows.';