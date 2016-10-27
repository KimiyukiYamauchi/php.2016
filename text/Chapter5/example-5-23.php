<?php

$dinner = 'Curry Cuttlefish';

function vegetarian_dinner() {
    global $dinner; // $dinnerはグローバル変数である
    print "Dinner was $dinner, but now it's ";
    $dinner = 'Sauteed Pea Shoots'; // グローバル変数の書き換え
    print $dinner;
    print "<br>\n";
}

print "Regular Dinner is $dinner.<br>\n";
vegetarian_dinner();
print "Regular dinner is $dinner";