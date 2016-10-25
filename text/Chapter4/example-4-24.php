<?php

$meal = array('breakfast' => 'Walnut Bun',
              'lunch' => 'Cashew Nuts and White Mushrooms',
              'snack' => 'Dried Mulberries',
              'dinner' => 'Eggplant with Chili Sauce');

print "Before Sorting:<br>\n";
foreach ($meal as $key => $value) {
    print "   \$meal: $key $value<br>\n";
}

asort($meal);

print "After Sorting:<br>\n";
foreach ($meal as $key => $value) {
    print "   \$meal: $key $value<br>\n";
}