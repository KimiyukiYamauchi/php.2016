<?php

$errors = array();
$_POST['price'] = '59.2a';

if ($_POST['price'] != strval(floatval($_POST['price']))) {
    $errors[] = 'Please enter a valid price.';
}else{
	$errors[] = "OK!(本来はメッセージは追加されない)";
}

var_dump($errors);