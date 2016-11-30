<?php
$limit = 1;
try{

	// sqlite3のtest.dbデータベースに接続
	$db = new PDO('sqlite:test2.db');
	// エラーになったら例外を投げる設定
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	// テストテーブル作成
	//$db->exec('create table test (type int)');
	$db->exec('insert into test (type) values (2)');
	$db->exec('insert into test (type) values (4)');

	// プリペアードクエリ
	$sql = 'select * from test where type = ? or type = ?';
	$stmt = $db->prepare($sql);
	$stmt->execute(array(1, 2));

	// 結果の取得
	$result = $stmt->fetchAll();

	var_dump($result);

}catch(PDOException $e){
	var_dump($e);
	die('Cannot Connect: ' . $e->getMessage() );
}