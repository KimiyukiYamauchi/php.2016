<?php
print <<<_HTML_
<form method="post" action="{$_SERVER['SCRIPT_NAME']}">
Your Name: <input type="text" name="user">
<br/>
<input type="submit" value="Say Hello">
</form>
_HTML_;
?>