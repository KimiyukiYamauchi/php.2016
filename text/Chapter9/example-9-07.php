<?php
$now = time();
$later = strtotime('Friday',$now);
$before = strtotime('last friday',$now);

$third_sat = strtotime('third saturday', $now); // add

print strftime("now: %c <br>\n", $now);
print strftime("later: %c <br>\n", $later);
print strftime("before: %c <br>\n", $before);

print strftime("third saturday: %c <br>\n", $third_sat); // add