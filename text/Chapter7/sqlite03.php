<?php
$limit = 1;
try{

	// sqlite3のtest.dbデータベースに接続
	$db = new PDO('sqlite:test.db');
	// エラーになったら例外を投げる設定
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	// テストテーブル作成
	$db->exec('create table test (type int)');
	$db->exec('insert into test (type) values (1)');
	$db->exec('insert into test (type) values (3)');

	// プリペアードクエリ
	$sql = 'select * from test where type = :type1 or type = :type2';
	$stmt = $db->prepare($sql);
	$stmt->execute(array(':type1' => 1, ':type2' => 2));

	// 結果の取得
	$result = $stmt->fetchAll();

	var_dump($result);

}catch(PDOException $e){
	die('Cannot Connect: ' . $e->getMessage() );
}