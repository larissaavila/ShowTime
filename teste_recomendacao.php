<?php

include 'Usuario.php';
	
	$usuario = new Usuario();
	$usuario->login('jvianadeavila');
	$usuario->recomendar();
	$recomendacoes = $usuario->getRecomendacoes();
	echo '<pre>' . print_r($recomendacoes, true) . '</pre>'; //Interessante para ver o formato do JSON

?>