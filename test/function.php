<?php
function display_wordpress(){
	echo 'WordPress';
}

// 2つの値を受け取って、足した結果を
// 返す関数
function add($n1, $n2){
	$answer = $n1 + $n2;
	return $answer;
}

display_wordpress();

echo "<br />\n";

$num = add(4, 5);
echo $num;

echo "<br />\n";

echo add(3, 4);