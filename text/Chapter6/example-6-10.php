<?php

$errors = array();
$_POST['email'] = 'test@test';

if (strlen($_POST['email']) == 0) {
   $errors[] = "You must enter an e-mail address.";
}else{
	$errors[] = "OK!(本来はメッセージは追加されない)";
}

var_dump($errors);