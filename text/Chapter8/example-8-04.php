<?php
// The cookie expires one hour from now
//setcookie('short-userid','ralph',time() + 60*60);
setcookie('short-userid','',time() + 60*60);

// The cookie expires one day from now
//setcookie('longer-userid','ralph',time() + 60*60*24);
setcookie('longer-userid','',time() + 60*60*24);

// The cookie expires at noon on October 1, 2006
//setcookie('much-longer-userid','ralph',mktime(0,0,0,12,31,2016));
setcookie('much-longer-userid','',mktime(0,0,0,12,31,2016));