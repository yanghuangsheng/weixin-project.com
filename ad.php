<?php
$url = '/index.php?m=admin';
Header("HTTP/1.1 303 See Other"); 
Header("Location: $url"); 

?>