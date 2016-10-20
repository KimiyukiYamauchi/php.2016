<?php

$price_1 = 1.01;
$price_2 = 1.01;

// こんな比較はやらないほうがいい
//if($price_1 == $price_2)
// 2つの少数点数の差が0.00001よりも小さい時は等しいとする
if(abs($price_1 - $price_2) < 0.00001) {
    print '$price_1 and $price_2 are equal.';
} else {
    print '$price_1 and $price_2 are not equal.';
}





