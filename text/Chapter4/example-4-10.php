<?php

$dinner = array('Sweet Corn and Asparagus',
                'Lemon Chicken',
                'Braised Bamboo Fungus');

var_dump($dinner);


foreach ($dinner as $dish) {
    print "You can eat: $dish<br>\n";
}