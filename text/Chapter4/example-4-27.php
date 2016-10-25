<?php

$meals = array('breakfast' => array('Walnut Bun','Coffee'),
               'lunch'     => array('Cashew Nuts', 'White Mushrooms'),
               'snack'     => array('Dried Mulberries','Salted Sesame Crab'));

$lunches = array( array('Chicken','Eggplant','Rice'),
                  array('Beef','Scallions','Noodles'),
                  array('Eggplant','Tofu'));

$flavors = array('Japanese' => array('hot' => 'wasabi',
                                     'salty' => 'soy sauce'),
                 'Chinese'  => array('hot' => 'mustard',
                                     'pepper-salty' => 'prickly ash'));

print $meals['lunch'][1];            // White Mushrooms
echo '<br>';
print $meals['snack'][0];            // Dried Mulberries
echo '<br>';
print $lunches[0][0];                // Chicken
echo '<br>';
print $lunches[2][1];                // Tofu
echo '<br>';
print $flavors['Japanese']['salty'];  // soy sauce
echo '<br>';
print $flavors['Chinese']['hot'];    // mustard

/*
var_dump($meals);
var_dump($lunches);
var_dump($flavors);
*/