<?php

require 'MDB2.php';	// PEARのMDB2モジュールをロード

// db_program://ユーザ名:パスワード@ドメイン名/データベース名
$db = MDB2::connect('mysqli://yamauchi:p@localhost/rensyu');
if (MDB2::isError($db)) { die("Can't connect: " . $db->getMessage()); }

// この後のデータベースエラーに関してはメッセージを出力して抜け出す
$db->setErrorHandling(PEAR_ERROR_DIE);

// Eggplant with Chili Sauce is spicy
$db->query("UPDATE dishes SET is_spicy = 1
            WHERE dish_name = 'Sesame Seed Puff'");
// Lobster with Chili Sauce is spicy and pricy
$db->query("UPDATE dishes SET is_spicy = 1, price=price * 2
            WHERE dish_name = 'Lobster with Chili Sauce'");