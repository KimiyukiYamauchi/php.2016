<?php

require 'MDB2.php';	// PEARのMDB2モジュールをロード

// db_program://ユーザ名:パスワード@ドメイン名/データベース名
$db = MDB2::connect('mysqli://yamauchi:p@localhost/rensyu?charset=utf8');
if (MDB2::isError($db)) { die("Can't connect: " . $db->getMessage()); }

// この後のデータベースエラーに関してはメッセージを出力して抜け出す
$db->setErrorHandling(PEAR_ERROR_DIE);

// 文字列キー付き配列にフェッチモードを変更
$db->setFetchMode(MDB2_FETCHMODE_ASSOC);

print "With query() and fetchRow(): <br>\n";
// get each row with query() and fetchRow();
$q = $db->query("SELECT dish_name, price FROM dishes");
while($row = $q->fetchRow()) {
    print "The price of $row[dish_name] is $row[price] <br>\n";
}

print "With getAll(): <br>\n";
// get all the rows with getAll();
$dishes = $db->queryAll('SELECT dish_name, price FROM dishes');
foreach ($dishes as $dish) {
    print "The price of $dish[dish_name] is $dish[price] <br>\n";
}

print "With getRow(): <br>\n";
$cheap = $db->queryRow('SELECT dish_name, price FROM dishes
    ORDER BY price LIMIT 1');
print "The cheapest dish is $cheap[dish_name] with price $cheap[price]";