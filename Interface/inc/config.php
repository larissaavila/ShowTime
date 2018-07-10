<?php

if(session_status()!=PHP_SESSION_ACTIVE)
	session_start();

/** caminho absoluto para a pasta do sistema **/
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** caminho no server para o sistema **/
if ( !defined('BASEURL') )
	define('BASEURL', '/edsa-ShowTime/');

define('HEADER_TEMPLATE', ABSPATH . 'inc/header.php');
define('FOOTER_TEMPLATE', ABSPATH . 'inc/footer.php');

function clear_messages(){
	$_SESSION['message']="";
    $_SESSION['type']="";
}

?>