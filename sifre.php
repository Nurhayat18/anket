<?php

$kul[0]['username']="kullanıcı adınız";
$kul[0]['password']="şifreniz";

// Dogrulama

function authenticate()
{
header( 'WWW-Authenticate: Basic realm="Mesajınız Buraya"' );
header( 'HTTP/1.0 401 Unauthorized' );
echo 'Authorization Required.';
exit;
}

if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) { authenticate(); } else
{
for($i=0;$i if($auth !=TRUE) {authenticate();}
}
?>