<?php

require 'MDB2.php';	// PEARのMDB2モジュールをロード

// db_program://ユーザ名:パスワード@ドメイン名/データベース名
$db = MDB2::connect('mysqli://yamauchi:p@localhost/rensyu?charset=utf8');
if (MDB2::isError($db)) { die("Can't connect: " . $db->getMessage()); }

// この後のデータベースエラーに関してはメッセージを出力して抜け出す
$db->setErrorHandling(PEAR_ERROR_DIE);

$_POST['dish_search'] = 'カレー';

// 最初は、値を標準クォ-ティングする
$dish = $db->quote($_POST['dish_search']);

// そして、アンダースコアとパーセント記号の前にバックスラッシュを置く
$dish = strtr($dish, array('_' => '\_', '%' => '\%'));

var_dump($dish);

// 部分一致で検索できるように検索文字列の前後に%を追加
$dish = preg_replace('/^\'/', '\'%', $dish);
$dish = preg_replace('/\'$/', '%\'', $dish);

var_dump($dish);

// Now, $dish is sanitized and can be interpolated right into the query
$matches = $db->queryAll("SELECT dish_name, price FROM dishes" .
							" WHERE dish_name LIKE $dish");

var_dump($matches);