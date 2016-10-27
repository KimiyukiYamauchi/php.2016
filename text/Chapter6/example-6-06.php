<?php

// $_POSTにキーが存在すれば、ポストされているので、
// process_form関数をよぶ
// $_POSTにキーがなければ、ポストされていないので、
// show_form関数をよぶ
if (array_key_exists('my_name',$_POST)) {
    process_form();
} else {
    show_form();
}

// フォームがサブミットされたとき何かをする
function process_form() {
    print "Hello, ". $_POST['my_name'];
}

// フォームを表示
function show_form() {
    print<<<_HTML_
<form method="POST" action="$_SERVER[PHP_SELF]">
Your name: <input type="text" name="my_name">
<br/>
<input type="submit" value="Say Hello">
</form>
_HTML_;
}