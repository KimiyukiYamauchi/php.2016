<?php

$defaults['my_name'] = 'ここに名前を入れて！';

print '<input type="text" name="my_name" value="' . 
      htmlentities($defaults['my_name']). '">';