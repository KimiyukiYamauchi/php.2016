<?php

$_POST['comments'] = <<<_COMM_

これはコメント<b>強調</b>です。<br>
これはコメント<i>イタリック</i>です。

_COMM_;

$comments = htmlentities($_POST['comments']);
// Now it's OK to print $comments
print $comments;