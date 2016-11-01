<?php

$errors = array();

// 今から６ヶ月前のエポックタイムスタンプを$range_startに代入
$range_start = strtotime('6 months ago');
// 現在のエポックタイムスタンプを$range_endに代入
$range_end   = time();

// 4-digit year is in $_POST['yr']
$_POST['yr'] = '2015';
// 2-digit month is in $_POST['mo']
$_POST['mo'] = '10';
// 2-digit day is is $_POST['dy']
$_POST['dy'] = '31';

// サブミットされた年月日のエポックタイムスタンプを$submitted_date
// に代入
$submitted_date = strtotime($_POST['yr'] . '-' . 
                            $_POST['mo'] . '-' . 
                            $_POST['dy']);

if (($range_start > $submitted_date) || ($range_end < $submitted_date)) {
    $errors[] = 'Please choose a date less than six months old.';
}else{
	$errors[] = "OK!(本来はメッセージは追加されない)";
}

var_dump($errors);