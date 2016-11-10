<?php

$defaults['comments'] = <<<_COM_
ここにコメントを入力してください
リターンで改行します
三行目
四行目

_COM_;

print '<textarea name="comments" rows="5" cols="30">';
print htmlentities($defaults['comments']);
print '</textarea>';