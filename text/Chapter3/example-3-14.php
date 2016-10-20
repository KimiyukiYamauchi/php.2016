<?php

$first_name = 'test';
$last_name = 'test';

// strcasecmp関数は引数の2つの文字列が等しい場合は
// 0を返す、phpは0をfalseと見るので、
// それの否定(!)はtrueになる
if (! strcasecmp($first_name,$last_name)) {
    print '２つの文字列は等しいです。';
}else{
	echo '２つの文字列は等しくありません。';
}
