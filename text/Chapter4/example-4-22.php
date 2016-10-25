<?php

//$fish = 'Bass, Carp, Pike, Flounder';
$fish = 'Bass:Carp:Pike:Flounder:test:testtest:testtesttest';
//$fish_list = explode(', ', $fish);
$fish_list = explode(':', $fish);
print "The second fish is $fish_list[1]";

var_dump($fish_list);