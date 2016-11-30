<?php
try{

	// sqlite3のtest.dbデータベースに接続
	$db = new PDO('sqlite:test.db');
	// エラーになったら例外を投げる設定
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$str = 'It\'s a nice day!';

	/* エスケープ処理をしないパターン */
	print "Unquoted string: $str<br>\n";

	/* エスケープ処理を行ったパターン */
	print "Quoted string: " . $db->quote($str) . "<br>\n";

}catch(PDOException $e){
	die('Cannot Connect: ' . $e->getMessage() );
}