<?php

$errors = array();
$_POST['name'] = '    a     ';

$_POST['name'] = trim($_POST['name']);

if (strlen($_POST['name']) == 0) {
    $errors[] = "Your name is required.";
}else{
	$errors[] = "OK!(本来はメッセージは追加されない)";
}

var_dump($errors);