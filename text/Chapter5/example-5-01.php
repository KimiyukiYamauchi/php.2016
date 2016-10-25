<?php

function page_header() {
    print '<html><head><title>Welcome to my site</title></head>';
    print '<body bgcolor="#ffffff">';
}

$user = 'やまうち';

page_header();
print "Welcome, $user";
print "</body></html>";