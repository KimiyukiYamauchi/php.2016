<?php

function restaurant_check2($meal, $tax, $tip) {
    $tax_amount  = $meal * ($tax / 100);
    $tip_amount  = $meal * ($tip / 100);
    $total_notip = $meal + $tax_amount;
    $total_tip   = $meal + $tax_amount + $tip_amount;

    return array('notip' => $total_notip, 'tip' => $total_tip);
}

$totals = restaurant_check2(15.22, 8.25, 15);

var_dump($totals);

if ($totals['notip'] < 20) {
    print 'The total without tip is less than $20.<br>';
}
if ($totals['tip'] < 20) {
    print 'The total with tip is less than $20.<br>';
}