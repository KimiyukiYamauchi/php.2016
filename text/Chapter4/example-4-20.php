<?php

$dimsum = array('Chicken Bun','Stuffed Duck Web','Turnip Cake');
//$menu = implode(', ', $dimsum);
$menu = '<ul><li>' . implode('</li><li>', $dimsum) . '</li></ul>';
print $menu;