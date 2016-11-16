<?php

require 'MDB2.php';	// PEARのMDB2モジュールをロード

// db_program://ユーザ名:パスワード@ドメイン名/データベース名
$db = MDB2::connect('mysqli://yamauchi:p@localhost/rensyu');
if (MDB2::isError($db)) { die("Can't connect: " . $db->getMessage()); }

$q = $db->query("CREATE TABLE dishes (
	dish_id INT primary key auto_increment,
	dish_name VARCHAR(255),
	price DECIMAL(4,2),
	is_spicy INT
)");

if (MDB2::isError($q)) { die("query error: " . $q->getMessage()); }


//$q = $db->query("drop table dishes");

echo 'OK!!!';