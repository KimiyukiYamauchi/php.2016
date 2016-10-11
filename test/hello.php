<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Hello</title>
</head>
<body>
<!-- 以下はphpで出力 -->
<?php
/* ここから
複数行用のコメント
ここまで */

$kosuu = 10;
echo 'みかんが' . $kosuu . '個あります。<br>';
echo "みかんが{$kosuu}個あります。<br>";
echo 'みかんが$kosuu個あります。<br>';

$number = 10;
echo $number;
echo '<br>';
$number = 20;
echo $number;
echo '<br>';


$food = array('りんご', 'みかん', 'なし');
echo $food[0];
echo '<br>';
echo $food[2];
echo '<br>';
var_dump($food);
echo '<br>';
$food = array(
		'apple' => 'りんご',
		'orange' => 'みかん',
		'pear' => 'なし',
	);
echo $food['apple'];
echo '<br>';
echo $food['pear'];
echo '<br>';
var_dump($food);


?>
<!-- 以上はphpで出力 -->

</body>
</html>