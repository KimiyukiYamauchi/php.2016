<?php

$finished = false;

// The entire test expression ($finished == false) 
// is true if $finished is false 
if ($finished == false) {
    print 'Not done yet!';
}

echo '<br>';

// The entire test expression (! $finished)
// is true if $finished is false
// falseが入っているかのチェックで、
// この書き方をよくするので注意!
if (! $finished) {
    print 'Not done yet!';
}