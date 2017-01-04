<?php

// Some sample usernames and passwords
$users = array('alice'   => 'dog123',
               'bob'     => 'my^pwd',
               'charlie' => '**fun**');

foreach( $users as $username => $password ){
	$hash = crypt($password, '$1$rasmusle$');
	echo $username . ' => ' . $hash  . "<br>\n";
}