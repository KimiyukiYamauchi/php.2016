<?php
$_POST['email'] = 'President@whitehouse.gov';
if ($_POST['email'] == 'president@whitehouse.gov') {
   print "Welcome, Mr. President.";
}else{
	echo 'NG!!!';
}