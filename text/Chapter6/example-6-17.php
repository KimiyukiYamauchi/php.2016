<?php

$errors = array();
$_POST['email'] = 'aaaaa@te-st.ab';

if (! preg_match('/^[^@\s]+@([-a-z0-9]+\.)+[a-z]{2,}$/i', 
                 $_POST['email'])) {
    $errors[] = 'Please enter a valid e-mail address';
}else{
	$errors[] = "OK!(本来はメッセージは追加されない)";
}

var_dump($errors);