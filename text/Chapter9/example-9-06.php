<?php
// get the values from a form

$_POST['hour'] = '21';
$_POST['minute'] = '15';
$_POST['month'] = '1';
$_POST['day'] = '5';
$_POST['year'] = '2017';

$user_date = mktime($_POST['hour'], $_POST['minute'], 0, $_POST['month'], $_POST['day'], $_POST['year']);

echo 'post epoc timestamp is ' . $user_date . '<br>';

// 1:30 pm (and 45 seconds) on October 20, 1982
$afternoon = mktime(13,30,45,10,20,1982);

print strftime('At %I:%M:%S on %m/%d/%y, ', $afternoon);
print "$afternoon seconds have elapsed since 1/1/1970.";