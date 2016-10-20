<?php

$letters[0] = 'A';
$letters[1] = 'B';
$letters[3] = 'D';
$letters[2] = 'C';

var_dump($letters);

foreach ($letters as $letter) {
    print $letter;
}

echo '<br>';

for($i=0, $num_letters = count($letters); $i<count($letters); $i++){
	print $letters[$i];
}