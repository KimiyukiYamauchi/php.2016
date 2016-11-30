<?php
$limit = 1;
try{

	// sqlite3のtest.dbデータベースに接続
	$db = new PDO('sqlite:test.db');
	// エラーになったら例外を投げる設定
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	// 通常のクエリを行う場合
	$stmt = $db->query('select * from dishes');
	// 結果の取得
	$result = $stmt->fetchAll();

	var_dump($result);

}catch(PDOException $e){
	die('Cannot Connect: ' . $e->getMessage() );
}