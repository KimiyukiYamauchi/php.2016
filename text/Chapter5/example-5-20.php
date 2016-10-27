<?php

$dinner = 'Curry Cuttlefish';

function vegetarian_dinner() {
	$dinner = '';
    print "Dinner is $dinner, or ";
    $dinner = 'Sauteed Pea Shoots'; 
    print $dinner;
    print "<br>\n";
}

function kosher_dinner() {
	$dinner = '';
    print "Dinner is $dinner, or ";
    $dinner = 'Kung Pao Chicken';
    print $dinner;
    print "<br>\n";
}

print "Vegetarian ";
vegetarian_dinner();
print "Kosher ";
kosher_dinner();
print "Regular dinner is $dinner";