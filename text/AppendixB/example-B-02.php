<?php

$_POST['zip'] = '12345';

// Test the value of $_POST['zip'] against the
// pattern ^\d{5}(-\d{4}?$
if (preg_match('/^\d{5}(-\d{4})?$/',$_POST['zip'])) {
    print $_POST['zip'] . ' is a valid US ZIP Code';
}else{
	echo $_POST['zip'] . ' NG!!!';
}

$html = <<<_HTML_

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<b>a</b>
</body>
</html>

_HTML_;

// Test the value of $html against the pattern <b>[^<]+</b>
// The delimiter is @ since / occurs in the pattern
$is_bold = preg_match('@<b>[^<]+</b>@',$html);

var_dump($is_bold);