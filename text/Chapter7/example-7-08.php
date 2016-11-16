<?php

require 'MDB2.php';	// PEARのMDB2モジュールをロード

// db_program://ユーザ名:パスワード@ドメイン名/データベース名
$db = MDB2::connect('mysqli://yamauchi:p@localhost/rensyu');
if (MDB2::isError($db)) { die("Can't connect: " . $db->getMessage()); }

// このドライバでトランザクションがサポートされているかどうかを調べます
if (!$db->supports('transactions')) {
	echo 'トランザクションがサポートされていないので終了';
    exit();
}

// トランザクションをオープンします
//$res = $db->beginTransaction();

$q = $db->query("INSERT INTO dishes (dish_name, price, is_spicy)
    VALUES ('transaction test', 2.50, 0)");

if (MDB2::isError($q)) { die("query error: " . $q->getMessage()); }

// コミットの処理
//$res = $db->commit();

if (MDB2::isError($res)) { die("query error: " . $res->getMessage()); }

echo 'OK!!!';